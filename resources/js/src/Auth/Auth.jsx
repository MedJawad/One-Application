import React, { useState } from "react";
import {
    Button,
    FormGroup,
    Col,
    FormControl,
    Form,
    Row,
    Container,
    Alert
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

    let authFailedMessage = null;
    const authError = useSelector(state => state.auth.error);
    if (authError) {
        let message = authError.message || "An error has occurred";
        if (message.includes("401")) message = "Wrong Username or Password";
        authFailedMessage = (
            <Col sm={{ span: 12 }}>
                {/* //   <Alert variant="danger">
      //     <p className="text-center">{authError.message}</p>
      //   </Alert> */}
                <div className="alert alert-danger text-center" role="alert">
                    <strong>{message}</strong>
                </div>
            </Col>
        );
    }
    return (
        <div className="content">
            {authRedirect}
            <Container>
                <Row>
                    <Col sm={{ span: 4, offset: 4 }}>
                        <Card
                            ctTableResponsive
                            style={{
                                background: "#f7f7f7",
                                margin: "100px auto",
                                boxShadow: " 0px 4px 4px rgba(0, 0, 0, 0.5)"
                            }}
                            content={
                                <Form onSubmit={handleSubmit}>
                                    <h2 className="text-center">Log in</h2>
                                    <FormGroup controlId="formHorizontalEmail">
                                        <Col sm={{ span: 12 }}>
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
                                        <Col sm={{ span: 12 }}>
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
                                            <Col sm={{ span: 12 }}>
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
                                    {authFailedMessage}
                                </Form>
                            }
                        />
                    </Col>
                </Row>
            </Container>
        </div>
    );
};

export default Auth;
