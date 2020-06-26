import React, { useState, useEffect } from "react";
import { Row, Col, Container, Card, Button, Form } from "react-bootstrap";
import qs from "querystring";

import api from "../../../API";
import { ClipLoader } from "react-spinners";
const PrevisionsForm = ({ setSubmittedCorrectly, handleFormSubmit }) => {
    const [loaded, setLoaded] = useState(false);
    const [formData, setFormData] = useState({
        infosType: "previsions",
        date: "",
        lastPrevisionsAdded: false,
        previsions: {
            "1H": 0,
            "2H": 0,
            "3H": 0,
            "4H": 0,
            "5H": 0,
            "6H": 0,
            "7H": 0,
            "8H": 0,
            "9H": 0,
            "10H": 0,
            "11H": 0,
            "12H": 0,
            "13H": 0,
            "14H": 0,
            "15H": 0,
            "16H": 0,
            "17H": 0,
            "18H": 0,
            "19H": 0,
            "20H": 0,
            "21H": 0,
            "22H": 0,
            "23H": 0,
            "24H": 0
        }
    });
    // console.log(formData);
    useEffect(() => {
        setLoaded(false);
        api.get("/newPrevisions")
            .then(res => {
                res.status === 230 &&
                    setFormData(oldState => {
                        return { ...oldState, lastPrevisionsAdded: true };
                    });
                res.status =
                    200 &&
                    setFormData(oldState => {
                        return { ...oldState, date: res.data.previsionsDate };
                    });
                return res;
            })

            .then(() => {
                setLoaded(true);
                // setSubmittedCorrectly(true);
            })
            .catch(err => err);

        // setTimeout(() => setSubmittedCorrectly(false), 2000);
    }, []);

    // const handleFormSubmit = e => {
    //     e.preventDefault();
    //     setLoaded(false);
    //     const data = JSON.stringify(formData);
    //     console.log(data);

    //     const newReportOptions = {
    //         method: method,
    //         url: `/reports`,
    //         data: data
    //     };
    //     api(newReportOptions)
    //         .then(res => {
    //             console.log(res);
    //             res.status === 200 && setSubmittedCorrectly(true);
    //             setLoaded(true);
    //         })
    //         .catch(error => {
    //             console.log(error);
    //             setSubmittedCorrectly(false);
    //             setLoaded(true);
    //         });
    // };
    const renderPrevisions = () => {
        const content = [];
        for (let e in formData.previsions) {
            content.push(
                <Form.Group key={e} className="m-1">
                    <Form.Label>{e}</Form.Label>
                    <Form.Control
                        type="number"
                        placeholder="Previsions"
                        value={formData.previsions[e]}
                        onChange={event => {
                            let value = event.target.value;
                            // console.log(value);
                            // console.log(isNaN(value));

                            if (
                                Number(value) < 0 ||
                                isNaN(value) ||
                                value.length === 0
                            ) {
                                return;
                            }
                            const newPrevisions = formData.previsions;
                            newPrevisions[e] = Number(value);
                            // console.log(newPrevisions[e]);

                            // newPrevisions[e] = value;
                            setFormData({
                                ...formData,
                                previsions: newPrevisions
                            });
                        }}
                    />
                </Form.Group>
            );
        }
        return content;
    };
    // console.log(qs.stringify(formData));

    if (!loaded)
        return (
            <Col md={{ span: 4, offset: 5 }}>
                <ClipLoader size={200} />
            </Col>
        );
    if (formData.lastPrevisionsAdded)
        return (
            <Col md={12}>
                <Card.Title>
                    Les prévisions d'aujourd'hui ont déja été ajoutés .
                </Card.Title>
                <Row>
                    <Button
                        variant="primary"
                        className="btn-fill ml-auto"
                        onClick={() => window.location.reload()}
                    >
                        Revenir
                    </Button>
                </Row>
            </Col>
        );
    return (
        <Form onSubmit={e => handleFormSubmit(e, formData)}>
            <Form.Row>
                <Form.Group as={Col}>
                    <Card.Title>
                        Previsions pour{" "}
                        <span className="badge badge-pill badge-primary m-2">
                            <b>{formData.date}</b>
                        </span>
                    </Card.Title>
                    <Form.Row>{renderPrevisions()}</Form.Row>
                </Form.Group>
            </Form.Row>

            <Form.Row>
                <Button
                    variant="primary"
                    type="submit"
                    className="btn-fill ml-auto"
                >
                    Valider
                </Button>
            </Form.Row>
        </Form>
    );
};

export default PrevisionsForm;
