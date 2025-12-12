import axios from 'axios';
import { getBookmarks, clearBookmarks } from './local';

export async function syncLocalBookmarks() {
    const localBookmarks = getBookmarks();

    if (!localBookmarks.length) {
        return { synced: false, bookmarks: [] };
    }

    const { data } = await axios.post('/bookmarks/sync', {
        bookmarks: localBookmarks,
    });

    clearBookmarks();

    return {
        synced: true,
        bookmarks: data.bookmarks ?? [],
    };
}

