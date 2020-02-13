const state = {
    user: null,
    userStatus: null
};
const getters = {
    user: state => {
        return state.user;
    },
    status: state => {
        return {
            user: state.userStatus
        };
    },
    friendship: state => {
        return state.user.data.attributes.friendship;
    },
    friendButtonText: (state, getters, rootState) => {
        if (rootState.User.user.data.user_id === state.user.data.user_id) {
            return "";
        } else if (getters.friendship === null) {
            return "Add Friend";
        } else if (
            getters.friendship.data.attributes.confirmed_at === null &&
            getters.friendship.data.attributes.friend_id !==
                rootState.User.user.data.user_id
        ) {
            return "Pending Request Friend";
        } else if (getters.friendship.data.attributes.confirmed_at !== null) {
            return "";
        }
        return "Accept";
    }
};
const actions = {
    async fetchUser({ commit }, userId) {
        commit("setUserStatus", "loading");
        await axios
            .get("/api/users/" + userId)
            .then(response => {
                commit("setUser", response.data);
                commit("setUserStatus", "success");
            })
            .catch(error => {
                commit("setUserStatus", "error");
                console.log("Unable to fetch user");
            });
    },

    async sendFriendRequest({ commit, state }, friendId) {
        await axios
            .post("/api/friend-request", { friend_id: friendId })
            .then(response => {
                commit("setUserFriendship", response.data);
            });
    },
    async acceptFriendRequest({ commit, state }, userId) {
        await axios
            .post("/api/friend-request-response", {
                user_id: userId,
                status: 1
            })
            .then(response => {
                commit("setUserFriendship", response.data);
            });
    },
    async ignoreFriendRequest({ commit, state }, userId) {
        await axios
            .delete("/api/friend-request-response/delete", {
                data: { user_id: userId }
            })
            .then(response => {
                commit("setUserFriendship", null);
            });
    }
};
const mutations = {
    setUser(state, user) {
        state.user = user;
    },
    setUserFriendship(state, friendship) {
        state.user.data.attributes.friendship = friendship;
    },
    setUserStatus(state, status) {
        state.userStatus = status;
    }
};
export default {
    state,
    getters,
    actions,
    mutations
};
