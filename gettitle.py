import os
import json
import requests
import html
import re
from deep_translator import GoogleTranslator
from slugify import slugify

# =========================
# KONFIGURASI
# =========================
ROOT = r"D:\Pii\manga"   # folder manga kamu (nama folder = judul)
OUTPUT = "metadata.json"
TRANSLATE = True
# =========================

ANILIST_API = "https://graphql.anilist.co"

QUERY = """
query ($search: String) {
  Media(search: $search, type: MANGA) {
    title {
      romaji
      english
      native
    }
    description
    startDate {
      year
    }
    status
    genres
    chapters
    averageScore
    coverImage {
      extraLarge
    }
    staff {
      edges {
        role
        node {
          name {
            full
          }
        }
      }
    }
  }
}
"""

translator = GoogleTranslator(source="en", target="id")

def translate_id(text):
    if not text:
        return None
    try:
        return translator.translate(text)
    except Exception as e:
        print("⚠️ Translate error:", e)
        return None




def fetch_anilist(title):
    res = requests.post(
        ANILIST_API,
        json={"query": QUERY, "variables": {"search": title}},
        headers={"Content-Type": "application/json"},
        timeout=20
    )
    return res.json().get("data", {}).get("Media")

def clean_description(text, max_length=1500):
    if not text:
        return None
    text = re.sub(r"<.*?>", "", text)
    text = html.unescape(text)
    return text[:max_length]



metadata_all = {}

for manga in os.listdir(ROOT):
    manga_path = os.path.join(ROOT, manga)
    if not os.path.isdir(manga_path):
        continue

    print(f"🔍 Ambil metadata: {manga}")
    media = fetch_anilist(manga)

    if not media:
        print(f"❌ Tidak ditemukan: {manga}")
        continue

    authors, artists = [], []
    for staff in media["staff"]["edges"]:
        role = staff["role"].lower()
        name = staff["node"]["name"]["full"]
        if "story" in role or "author" in role:
            authors.append(name)
        if "art" in role or "illustration" in role:
            artists.append(name)

    description_en = clean_description(media["description"])
    description_id = translate_id(description_en)



    slug = slugify(media["title"]["romaji"] or manga)

    metadata_all[slug] = {
        "title": media["title"]["romaji"],
        "titles": media["title"],
        "description_id": description_id,
        "year": media["startDate"]["year"],
        "status": media["status"],
        "genres": media["genres"],
        "authors": sorted(set(authors)),
        "artists": sorted(set(artists)),
        "chapters": media["chapters"],
        "score": media["averageScore"],
        "cover": media["coverImage"]["extraLarge"],
        "source": "AniList"
    }

with open(OUTPUT, "w", encoding="utf-8") as f:
    json.dump(metadata_all, f, indent=2, ensure_ascii=False)

print(f"\n🎉 SELESAI — Semua metadata disimpan ke {OUTPUT}")
