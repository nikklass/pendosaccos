
const state = {
    now: new Date
};

const mutations = {
    updateTime (state) {
        state.now = new Date
    }
};

const actions = {
    start ({ commit }) {
        setInterval(() => {
            commit('updateTime')
        }, 1000 * 60)
    }
};

const getters = {
    today (state) {
        return startOfDay(state.now)
    }
};

export default {
    state,
    mutations,
    actions,
    getters
};