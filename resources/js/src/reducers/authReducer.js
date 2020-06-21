import userActions from "../actions/actionTypes";

const initialState = {
  isLoading: false,
  isLoaded: false,
  error: null,
  token: null,
};

export const auth = (state = initialState, action) => {
  switch (action.type) {
    case userActions.REQUEST:
      return {
        ...state,
        isLoading: true,
        isLoaded: false,
        error: null,
      };
    case userActions.SUCCESS:
      return {
        ...state,
        isLoading: false,
        isLoaded: true,
        error: null,
        token: action.token,
        role: action.role,
      };
    case userActions.FAILURE:
      return {
        ...state,
        isLoading: false,
        isLoaded: false,
        error: action.error,
        token: null,
      };
    case userActions.LOGOUT:
      return initialState;
    default:
      return state;
  }
};
