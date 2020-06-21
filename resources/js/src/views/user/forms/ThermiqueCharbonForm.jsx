import React, { useState, useEffect } from "react";
import { Row, Col, Container, Card, Button, Form } from "react-bootstrap";
import qs from "querystring";

import api from "../../../API";
const ThermiqueCharbonForm = ({
    selectedCentrale,
    setLoaded,
    setSubmittedCorrectly,
    handleFormSubmit
}) => {
    const [formData, setFormData] = useState({
        horaire: selectedCentrale.horaire,
        date: selectedCentrale.date,
        autonomie_charbon: 0,
        production_totale_brut: 0,
        production_totale_net: 0,
        productions: {}
    });
    useEffect(() => {
        const productionHours = [];

        switch (selectedCentrale.horaire) {
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
        const productions = {};
        for (let hour in productionHours) {
            productions[productionHours[hour]] = 0;
        }
        setFormData({ ...formData, productions });
    }, []);
    console.log(formData);

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
    const renderProduction = () => {
        const content = [];
        for (let e in formData.productions) {
            content.push(
                <Form.Group as={Col} key={e}>
                    <Form.Label>{e}</Form.Label>
                    <Form.Control
                        type="number"
                        placeholder="Productions"
                        value={formData.productions[e]}
                        onChange={event => {
                            let value = event.target.value;
                            console.log(value);
                            console.log(isNaN(value));

                            if (
                                Number(value) < 0 ||
                                isNaN(value) ||
                                value.length === 0
                            ) {
                                return;
                            }
                            const newProductions = formData.productions;
                            newProductions[e] = Number(value);
                            console.log(newProductions[e]);

                            // newProduction[e] = value;
                            setFormData({
                                ...formData,
                                productions: newProductions
                            });
                        }}
                    />
                </Form.Group>
            );
        }
        return content;
    };
    // console.log(qs.stringify(formData));

    if (selectedCentrale.lastHourAdded) {
        return (
            <Col md={12}>
                <Card.Title>
                    Les derniers informations du{" "}
                    <b>
                        {selectedCentrale.type +
                            " " +
                            selectedCentrale.nom +
                            " "}
                    </b>
                    ont déja été ajouté, veuillez attendre jusqu'au prochain
                    horaire.
                </Card.Title>
            </Col>
        );
    }
    return (
        <Form onSubmit={e => handleFormSubmit(e, formData)}>
            <Card.Title>
                Veuillez remplir les informations du:
                <b>{` ${selectedCentrale.type} ${selectedCentrale.nom} à `}</b>
                <span className="badge badge-pill badge-primary m-2">
                    <b>
                        {" "}
                        {selectedCentrale.date} à {selectedCentrale.horaire}H
                    </b>
                </span>
            </Card.Title>

            <Form.Row>
                <Form.Group as={Col}>
                    <Form.Label>Productions</Form.Label>
                    <Form.Row>{renderProduction()}</Form.Row>
                </Form.Group>
            </Form.Row>
            {selectedCentrale.horaire === "24" && (
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
                    {selectedCentrale.subtype != "-autonomie" && (
                        <Form.Group as={Col}>
                            <Form.Label>Autonomie Charbon à 24H</Form.Label>
                            <Form.Control
                                type="number"
                                placeholder="Autonomie Charbon à 24H"
                                value={formData.autonomie_charbon}
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
                                        autonomie_charbon: target.value
                                    });
                                }}
                            />
                        </Form.Group>
                    )}
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

export default ThermiqueCharbonForm;
