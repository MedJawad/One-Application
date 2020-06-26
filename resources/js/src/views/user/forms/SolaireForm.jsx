import React, { useState, useEffect } from "react";
import { Row, Col, Container, Card, Button, Form } from "react-bootstrap";
import qs from "querystring";

import api from "../../../API";
const SolaireForm = ({
    horaire,
    setLoaded,
    setSubmittedCorrectly,
    handleFormSubmit
}) => {
    const [formData, setFormData] = useState({
        horaire,
        cote: 0,
        lache: 0,
        turbine: 0,
        irrigation: 0,
        production_totale_brut: 0,
        production_totale_net: 0,
        production: {}
    });
    useEffect(() => {
        const productionHours = [];

        switch (horaire) {
            case "7":
                productionHours.push("1H", "2H", "3H", "4H", "5H", "6H");
                break;
            case "13":
                productionHours.push("7H", "8H", "9H", "10H", "11H", "12H");

                break;
            case "21":
                productionHours.push(
                    "13H",
                    "14H",
                    "15H",
                    "16H",
                    "17H",
                    "18H",
                    "19H",
                    "20H"
                );

                break;
            case "24":
                productionHours.push("21H", "22H", "23H", "24H");

                break;
            default:
                break;
        }
        const production = {};
        for (let hour in productionHours) {
            production[productionHours[hour]] = 0;
        }
        setFormData({ ...formData, production });
    }, []);
    console.log(formData);

    // const handleFormSubmit = e => {
    //     e.preventDefault();
    //     setLoaded(false);
    //     // let formdata = new FormData();
    //     // formdata.append("data", JSON.stringify(formData));
    //     // console.log(formdata);
    //     // const data = {
    //     //   ...formData,
    //     //   production: JSON.stringify(formData.production),
    //     // };
    //     const data = JSON.stringify(formData);
    //     console.log(data);

    //     const newReportOptions = {
    //         method: method,
    //         url: `/reports`,
    //         data: data
    //         // headers: {
    //         //   "Content-Type": "application/x-www-form-urlencoded",
    //         // },
    //         // json: true,
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
    const renderProduction = () => {
        const content = [];
        for (let e in formData.production) {
            content.push(
                <Form.Group as={Col} key={e}>
                    <Form.Label>{e}</Form.Label>
                    <Form.Control
                        type="number"
                        placeholder="Production"
                        value={formData.production[e]}
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
                            const newProduction = formData.production;
                            newProduction[e] = Number(value);
                            // console.log(newProduction[e]);

                            // newProduction[e] = value;
                            setFormData({
                                ...formData,
                                production: newProduction
                            });
                        }}
                    />
                </Form.Group>
            );
        }
        return content;
    };
    // console.log(qs.stringify(formData));

    return (
        <Form onSubmit={e => handleFormSubmit(e, formData)}>
            <Form.Row>
                <Form.Group as={Col}>
                    <Form.Label>Cote</Form.Label>
                    <Form.Control
                        type="number"
                        placeholder="Cote"
                        value={formData.cote}
                        onChange={({ target }) => {
                            if (
                                Number(target.value) < 0 ||
                                isNaN(target.value) ||
                                target.value.length === 0
                            ) {
                                return;
                            }
                            setFormData({
                                ...formData,
                                cote: Number(target.value)
                            });
                        }}
                    />
                </Form.Group>

                <Form.Group as={Col} controlId="formGridPassword">
                    <Form.Label>Laché</Form.Label>
                    <Form.Control
                        type="number"
                        placeholder="Laché"
                        value={formData.lache}
                        onChange={({ target }) => {
                            if (
                                Number(target.value) < 0 ||
                                isNaN(target.value) ||
                                target.value.length === 0
                            ) {
                                return;
                            }
                            setFormData({
                                ...formData,
                                lache: Number(target.value)
                            });
                        }}
                    />
                </Form.Group>
            </Form.Row>
            {horaire === "24" && (
                <Form.Row>
                    <Form.Group as={Col}>
                        <Form.Label>Turbiné</Form.Label>
                        <Form.Control
                            type="number"
                            placeholder="Turbiné"
                            value={formData.turbine}
                            onChange={({ target }) => {
                                if (
                                    Number(target.value) < 0 ||
                                    isNaN(target.value) ||
                                    target.value.length === 0
                                ) {
                                    return;
                                }
                                setFormData({
                                    ...formData,
                                    turbine: target.value
                                });
                            }}
                        />
                    </Form.Group>
                    <Form.Group as={Col}>
                        <Form.Label>Irrigation</Form.Label>
                        <Form.Control
                            type="number"
                            placeholder="Irrigation"
                            value={formData.irrigation}
                            onChange={({ target }) => {
                                if (
                                    Number(target.value) < 0 ||
                                    isNaN(target.value) ||
                                    target.value.length === 0
                                ) {
                                    return;
                                }
                                setFormData({
                                    ...formData,
                                    irrigation: target.value
                                });
                            }}
                        />
                    </Form.Group>
                </Form.Row>
            )}
            <Form.Row>
                <Form.Group as={Col}>
                    <Form.Label>Production</Form.Label>
                    <Form.Row>{renderProduction()}</Form.Row>
                </Form.Group>
            </Form.Row>
            {horaire === "24" && (
                <Form.Row>
                    <Form.Group as={Col}>
                        <Form.Label>Production Totale Brut</Form.Label>
                        <Form.Control
                            type="number"
                            placeholder="Production Totale Brut"
                            value={formData.production_totale_brut}
                            onChange={({ target }) => {
                                if (
                                    Number(target.value) < 0 ||
                                    isNaN(target.value) ||
                                    target.value.length === 0
                                ) {
                                    return;
                                }
                                setFormData({
                                    ...formData,
                                    production_totale_brut: target.value
                                });
                            }}
                        />
                    </Form.Group>
                    <Form.Group as={Col}>
                        <Form.Label>Production Totale Net</Form.Label>
                        <Form.Control
                            type="number"
                            placeholder="Production Totale Net"
                            value={formData.production_totale_net}
                            onChange={({ target }) => {
                                if (
                                    Number(target.value) < 0 ||
                                    isNaN(target.value) ||
                                    target.value.length === 0
                                ) {
                                    return;
                                }
                                setFormData({
                                    ...formData,
                                    production_totale_net: target.value
                                });
                            }}
                        />
                    </Form.Group>
                </Form.Row>
            )}
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

export default SolaireForm;
