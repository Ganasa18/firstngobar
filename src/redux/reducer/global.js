initGlobal = {
  isLoading: true,
};

export const globalReducer = (state = initGlobal, action) => {
  switch (action.type) {
    case "SET_IS_LOADING":
      return {
        ...state,
        isLoading: action.value,
      };

    default:
      return state;
  }
};
