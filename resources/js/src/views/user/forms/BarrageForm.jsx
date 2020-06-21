import React, { useState, useEffect } from "react";
import { Row, Col, Container, Card, Button, Form } from "react-bootstrap";
import qs from "querystring";

import api from "../../../API";
const BarrageForm = ({
    selectedCentrale,
    setLoaded,
    setSubmittedCorrectly,
    handleFormSubmit
}) => {
    const [formData, setFormData] = useState({
        horaire: selectedCentrale.horaire,
        date: selectedCentrale.date,
        cote: 0,
        cote2: 0,
        lache: 0,
        turbine: 0,
        irrigation: 0,
        volume_pompe: 0,
        production_totale_brut: 0,
        production_totale_net: 0,
        productions: {}
    });
    useEffect(() => {
        const productionsHours = [];

        switch (selectedCentrale.horaire) {
            case "7":
                productionsHours.push("1H", "2H", "3H", "4H", "5H", "6H");
                break;
            case "11":
                productionsHours.push("7H", "8H", "9H", "10H");

                break;
            case "14":
                productionsHours.push("11H", "12H", "13H");

                break;
            case "24":
                productionsHours.push(
                    "14H",
                    "15H",
                    "16H",
                    "17H",
                    "18H",
                    "19H",
                    "20H",
                    "21H",
                    "22H",
                    "23H",
                    "24H"
                );

                break;
            default:
                break;
        }
        const productions = {};
        for (let hour in productionsHours) {
            productions[productionsHours[hour]] = 0;
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

    if (selectedCentrale.lastHourAdded) {
        return (
            <Card.Title>
                Les derniers informations du{" "}
                <b>
                    {selectedCentrale.type + " " + selectedCentrale.nom + " "}
                </b>
                ont déja été ajouté, veuillez attendre jusqu'au prochain
                horaire.
            </Card.Title>
        );
    }

    const renderproductions = () => {
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
                            const newproductions = formData.productions;
                            newproductions[e] = Number(value);
                            console.log(newproductions[e]);
                            setFormData({
                                ...formData,
                                productions: newproductions
                            });
                        }}
                    />
                </Form.Group>
            );
        }
        return content;
    };

    if (selectedCentrale.subtype === "onlyVolumePompe") {
        return (
            <Form onSubmit={e => handleFormSubmit(e, formData)}>
                <Card.Title>
                    Veuillez remplir les informations du:
                    <b>{` ${selectedCentrale.type} ${selectedCentrale.nom} à `}</b>
                    <span className="badge badge-pill badge-primary m-2">
                        <b>
                            {" "}
                            {selectedCentrale.date} {selectedCentrale.horaire}H
                        </b>
                    </span>
                </Card.Title>
                <Form.Row>
                    <Form.Group as={Col}>
                        <Form.Label>Volume Pompé</Form.Label>
                        <Form.Control
                            type="number"
                            placeholder="Volume Pompé"
                            value={formData.volume_pompe}
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
                                    volume_pompe: target.value
                                });
                            }}
                        />
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
    }
    return (
        <Form onSubmit={e => handleFormSubmit(e, formData)}>
            <Card.Title>
                Veuillez remplir les informations du:
                <b>{` ${selectedCentrale.type} ${selectedCentrale.nom} à `}</b>
                <span className="badge badge-pill badge-primary m-2">
                    <b>
                        {" "}
                        {selectedCentrale.date} {selectedCentrale.horaire}H
                    </b>
                </span>
            </Card.Title>
            <Form.Row>
                {selectedCentrale.subtype != "-cote" && (
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
                )}
                {selectedCentrale.subtype == "+cote" && (
                    <Form.Group as={Col}>
                        <Form.Label>Cote 2</Form.Label>
                        <Form.Control
                            type="number"
                            placeholder="Cote 2"
                            value={formData.cote2}
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
                                    cote2: Number(target.value)
                                });
                            }}
                        />
                    </Form.Group>
                )}
                {selectedCentrale.subtype != "onlyProductionCote" && (
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
                )}
            </Form.Row>
            {selectedCentrale.subtype != "onlyProductionCote" && (
                <>
                    {selectedCentrale.horaire === "24" && (
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
                </>
            )}
            <Form.Row>
                <Form.Group as={Col}>
                    <Form.Label>Productions</Form.Label>
                    <Form.Row>{renderproductions()}</Form.Row>
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

export default BarrageForm;