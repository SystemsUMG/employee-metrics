export default {
    namespaced: true,
    state: {
        user: null,
        auth: false
    },
    mutations: {
        SET_USER(state, user) {
            state.user = user;
        }
    },
    actions: {
        async login(credentials) {
            await axios.get("/sanctum/csrf-cookie");
            await axios.post("/login", credentials);
            return dispatchEvent("getUser");
        },
        getUser({ commit }) {
            axios.get("/user").then((response) => {
                commit('SET_USER', response.data);
            }).catch(()=>{
                commit('SET_USER', null);
            })
        }
    }
};
