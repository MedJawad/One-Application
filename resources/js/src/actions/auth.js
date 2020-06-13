import userActions from "./actionTypes";
import axios from "axios";
import Cookies from "universal-cookie";
const cookies = new Cookies();
const queryString = require("querystring");

const request = () => {
  return { type: userActions.REQUEST };
};
const success = (data) => {
  return { type: userActions.SUCCESS, token: data.token };
};
const failure = (error) => {
  return { type: userActions.FAILURE, error };
};

const loginWithCookie = () => {
  const token = cookies.get("token");
  if (token) return { type: userActions.SUCCESS, token: token.token };
  return { type: "COOKIE_NOT_FOUND" };
};

const login = (userCredentials) => {
  const authOptions = {
    method: "POST",
    url: `/api/login`,
    data: queryString.stringify(userCredentials),
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    json: true,
  };
  return (dispatch) => {
    dispatch(request());
    axios(authOptions)
      .then((res) => (res.status === 200 ? res.data : console.log(res)))
      .then((data) => {
        cookies.set("token", data.success, {
          maxAge: 3600,
        });
        return dispatch(success(data.success));
      })
      .catch((error) => dispatch(failure(error)));
  };
};

const logout = () => {
  cookies.remove("token");
  return { type: userActions.LOGOUT };
};
export default { login, loginWithCookie, logout };