import { combineReducers } from "redux";
// import { files } from "./filesReducer";
// import { locations } from "./locationsReducer";
import { auth } from "./authReducer";
const RootReducer = combineReducers({
  auth,
});

export default RootReducer;
