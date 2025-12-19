import os
import re
from PIL import Image

# =========================
ROOT = r"D:\Pii\manga"
START_INDEX = 1
START_CHAPTER_NAME = 1
WEBP_QUALITY = 80
# =========================


def is_image(name):
    return name.lower().endswith((".png", ".jpg", ".jpeg", ".webp"))


def extract_number(name):
    match = re.search(r'\d+', name)
    return int(match.group()) if match else 0


for manga in os.listdir(ROOT):
    manga_path = os.path.join(ROOT, manga)
    if not os.path.isdir(manga_path):
        continue

    # 🔥 SORT BERDASARKAN ANGKA DI NAMA FOLDER
    chapters = sorted(
        [d for d in os.listdir(manga_path) if os.path.isdir(os.path.join(manga_path, d))],
        key=extract_number
    )

    chapter_number = START_CHAPTER_NAME

    for idx, ch in enumerate(chapters, start=1):
        if idx < START_INDEX:
            continue

        ch_path = os.path.join(manga_path, ch)
        new_ch = f"chapter-{chapter_number}"
        new_path = os.path.join(manga_path, new_ch)

        if ch != new_ch:
            os.rename(ch_path, new_path)
        else:
            new_path = ch_path

        images = sorted(f for f in os.listdir(new_path) if is_image(f))

        for i, img in enumerate(images, start=1):
            img_path = os.path.join(new_path, img)
            new_img = f"page-{i}.webp"
            new_img_path = os.path.join(new_path, new_img)

            with Image.open(img_path).convert("RGB") as im:
                im.save(
                    new_img_path,
                    "WEBP",
                    quality=WEBP_QUALITY,
                    method=6
                )

            if img_path != new_img_path:
                os.remove(img_path)

        chapter_number += 1

print("SELESAI ✔ Sorting numerik berhasil")
