import axios from 'axios';
import { defineStore } from 'pinia';

export const usePostsStore = defineStore('posts', {
  state: () => ({
    posts: []
  }),
  getters: {
    getPosts: state => state.posts
  },
  actions: {
    async fetchPosts(params) {
        try {
            const response = await axios.get(`/posts/list`, {
                params: params
            });
            this.posts = response.data
        } catch (error) {
            console.log(error);
        }
    }
  },
});
