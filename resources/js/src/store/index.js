import { createStore, applyMiddleware } from "redux";
import thunk from "redux-thunk";
// import { composeWithDevTools } from "redux-devtools-extension";
import RootReducer from "../reducers/index";
const store = createStore(
    RootReducer,
    applyMiddleware(thunk)//composeWithDevTools()
);

export default store;
