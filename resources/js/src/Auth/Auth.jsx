import React, { useState } from "react";
import {
    Button,
    FormGroup,
    Col,
    FormControl,
    Form,
    Grid,
    Row
} from "react-bootstrap";
import { Redirect } from "react-router-dom";
import { useDispatch, useSelector } from "react-redux";
import { BeatLoader } from "react-spinners";

import Card from "../components/Card/Card";
import auth from "../actions/auth";

const Auth = () => {
    const [formData, setFormData] = useState({ username: "", password: "" });
    const dispatch = useDispatch();
    function handleChange(event) {
        const name = event.target.name;
        if (name === "username") {
            setFormData({
                username: event.target.value,
                password: formData.password
            });
        } else if (name === "password") {
            setFormData({
                username: formData.username,
                password: event.target.value
            });
        }
    }

    function handleSubmit(event) {
        event.preventDefault();
        dispatch(auth.login(formData));
    }

    const isLoading = useSelector(state => state.auth.isLoading);
    const beatloaderCSS = {
        width: "50%",
        margin: "auto;",
        textAlign: "center"
    };
    let authRedirect = null;
    if (useSelector(state => state.auth.token != null)) {
        authRedirect = <Redirect to="/" />;
    }
    return (
        <div className="content">
            {authRedirect}
            <Grid fluid>
                <Row>
                    <Col md={4} mdOffset={4}>
                        <Card
                            ctTableResponsive
                            style={{
                                background: "#f7f7f7",
                                margin: "100px auto",
                                boxShadow: " 0px 4px 4px rgba(0, 0, 0, 0.5)"
                            }}
                            content={
                                <Form horizontal onSubmit={handleSubmit}>
                                    <h2 className="text-center">Log in</h2>
                                    <FormGroup controlId="formHorizontalEmail">
                                        <Col smOffset={1} sm={10}>
                                            <FormControl
                                                type="text"
                                                name="username"
                                                placeholder="Username"
                                                required="required"
                                                value={formData.username}
                                                onChange={handleChange}
                                            />
                                        </Col>
                                    </FormGroup>

                                    <FormGroup controlId="formHorizontalPassword">
                                        <Col smOffset={1} sm={10}>
                                            <FormControl
                                                type="password"
                                                name="password"
                                                placeholder="Password"
                                                required="required"
                                                value={formData.password}
                                                onChange={handleChange}
                                            />
                                        </Col>
                                    </FormGroup>

                                    {isLoading ? (
                                        <BeatLoader
                                            css={beatloaderCSS}
                                            color={"#3472F7"}
                                        />
                                    ) : (
                                        <FormGroup>
                                            <Col smOffset={1} sm={10}>
                                                <Button
                                                    type="submit"
                                                    className="btn btn-primary btn-fill btn-block"
                                                    style={{
                                                        fontSize: "15px",
                                                        fontWeight: "bold"
                                                    }}
                                                >
                                                    Log in
                                                </Button>
                                            </Col>
                                        </FormGroup>
                                    )}
                                </Form>
                            }
                        />
                    </Col>
                </Row>
            </Grid>
        </div>
    );
};

export default Auth;
