const state = {
    posts: null,
    postsStatus: null,
    postMessage: ''
};
const getters = {
    posts: state => {
        return state.posts;
    },
    postMessage: state => {
        return state.postMessage;
    },
    newsStatus: state => {
        return {
            postsStatus: state.postsStatus
        };
    }
};
const actions = {
    async fetchPosts({ commit, state }) {
        commit("setPostsStatus", "loading");
        await axios
            .get("/api/posts")
            .then(response => {
                commit("setPosts", response.data);

                commit("setPostsStatus", "success");
            })
            .catch(error => {
                commit("setPostsStatus", "error");
            });
    },
    async fetchUserPosts({ commit }, userId) {
        commit("setPostsStatus", "loading");
        await axios
            .get("/api/users/" + userId + "/posts")
            .then(response => {
                commit("setPosts", response.data);
                commit("setPostsStatus", "success");
            })
            .catch(error => {
                commit("setPostsStatus", "error");
                console.log("Unable to fetch posts");
            });
    },
    async postMessage({ commit, state }) {
        await axios
            .post("/api/posts", {
                body: state.postMessage
            })
            .then(response => {
                commit("pushPost", response.data);
                commit("updateMessage", "");
                commit("setPostsStatus", "success");
            })
            .catch(error => {
                commit("setPostsStatus", "error");
            });
    },
    async likePost({ commit, state }, data) {
        await axios
            .post("/api/posts/" + data.postId + "/like")
            .then(response => {
                commit("pushLike", {
                    likes: response.data,
                    postKey: data.postKey
                });
            });
    },
    async commentPost({ commit, state }, data) {
        await axios
            .post("/api/posts/" + data.postId + "/comment", { body: data.body })
            .then(response => {
                commit("pushComment", {
                    comments: response.data,
                    postKey: data.postKey
                });
            });
    }
};
const mutations = {
    setPosts(state, posts) {
        state.posts = posts;
    },
    setPostsStatus(state, status) {
        state.postsStatus = status;
    },
    updateMessage(state, message) {
        state.postMessage = message;
    },
    pushPost(state, post) {
        state.posts.data.unshift(post);
    },
    pushLike(state, data) {
        state.posts.data[data.postKey].data.attributes.likes = data.likes;
    },
    pushComment(state, data) {
        state.posts.data[data.postKey].data.attributes.comments = data.comments;
    }
};
export default {
    state,
    getters,
    actions,
    mutations
};
