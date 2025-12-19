import os
import json
import requests
import html

# =========================
# KONFIGURASI
# =========================
ROOT = r"D:\Pii\manga"   # folder manga kamu
LANGUAGE = "english"     # english | romaji | native
# =========================

ANILIST_API = "https://graphql.anilist.co"

QUERY = """
query ($search: String) {
  Media(search: $search, type: MANGA) {
    id
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

def fetch_metadata(title):
    response = requests.post(
        ANILIST_API,
        json={"query": QUERY, "variables": {"search": title}},
        headers={"Content-Type": "application/json"}
    )
    data = response.json()
    return data.get("data", {}).get("Media")

for manga in os.listdir(ROOT):
    manga_path = os.path.join(ROOT, manga)
    if not os.path.isdir(manga_path):
        continue

    print(f"🔍 Mencari metadata: {manga}")
    media = fetch_metadata(manga)

    if not media:
        print(f"❌ Tidak ditemukan: {manga}")
        continue

    # Pilih judul
    title = media["title"].get(LANGUAGE) or media["title"]["romaji"]

    # Ambil author & artist
    authors = []
    artists = []
    for staff in media["staff"]["edges"]:
        role = staff["role"].lower()
        name = staff["node"]["name"]["full"]
        if "story" in role or "author" in role:
            authors.append(name)
        if "art" in role or "illustration" in role:
            artists.append(name)

    metadata = {
        "title": title,
        "titles": media["title"],
        "description": html.unescape(media["description"] or ""),
        "year": media["startDate"]["year"],
        "status": media["status"],
        "genres": media["genres"],
        "authors": list(set(authors)),
        "artists": list(set(artists)),
        "source": "AniList"
    }

    output = os.path.join(manga_path, "metadata.json")
    with open(output, "w", encoding="utf-8") as f:
        json.dump(metadata, f, indent=2, ensure_ascii=False)

    print(f"✅ Metadata disimpan: {output}")

print("🎉 SELESAI – Semua metadata diproses")
