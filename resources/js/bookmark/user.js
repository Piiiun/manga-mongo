import axios from 'axios';

export async function fetchUserBookmarks() {
    const { data } = await axios.get('/bookmarks');
    return data.bookmarks ?? [];
}

export async function toggleUserBookmark(mangaId) {
    const { data } = await axios.post('/bookmarks/toggle', {
        manga_id: mangaId,
    });

    return {
        bookmarked: Boolean(data.bookmarked),
        count: data.count ?? 0,
    };
}

