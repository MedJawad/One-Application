import React, { useState, useEffect } from "react";
import { Row, Col, Container, Card, Button, Form } from "react-bootstrap";
import qs from "querystring";

import api from "../../../API";
const TurbineGazForm = ({
    selectedCentrale,
    setLoaded,
    setSubmittedCorrectly,
    handleFormSubmit
}) => {
    const [formData, setFormData] = useState({
        horaire: selectedCentrale.horaire,
        date: selectedCentrale.date,
        production_totale_brut: 0,
        production_totale_net: 0,
        production_gazoil: 0,
        livraison_charbon: 0,
        consommation_charbon: 0,
        transfert_charbon: 0,
        livraison_fioul: 0,
        consommation_fioul: 0,
        transfert_fioul: 0,
        livraison_gazoil: 0,
        consommation_gazoil: 0,
        transfert_gazoil: 0,
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
                Veuillez remplir les informations du :
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
                <>
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
                    <Form.Row>
                        <Form.Group as={Col}>
                            <Form.Label>Fioul Livraison</Form.Label>
                            <Form.Control
                                type="number"
                                placeholder="Livraison Fioul"
                                value={formData.livraison_fioul}
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
                                        livraison_fioul: target.value
                                    });
                                }}
                            />
                        </Form.Group>
                        <Form.Group as={Col}>
                            <Form.Label>Fioul Consommation</Form.Label>
                            <Form.Control
                                type="number"
                                placeholder="Consommation Fioul"
                                value={formData.consommation_fioul}
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
                                        consommation_fioul: target.value
                                    });
                                }}
                            />
                        </Form.Group>
                        <Form.Group as={Col}>
                            <Form.Label>Fioul Transfert</Form.Label>
                            <Form.Control
                                type="number"
                                placeholder="Transfert Fioul"
                                value={formData.transfert_fioul}
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
                                        transfert_fioul: target.value
                                    });
                                }}
                            />
                        </Form.Group>
                    </Form.Row>
                    {selectedCentrale.subtype === "+gazoil" && (
                        <Form.Row>
                            <Form.Group as={Col}>
                                <Form.Label>Gazoil Livraison</Form.Label>
                                <Form.Control
                                    type="number"
                                    placeholder="Livraison Gazoil"
                                    value={formData.livraison_gazoil}
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
                                            livraison_gazoil: target.value
                                        });
                                    }}
                                />
                            </Form.Group>
                            <Form.Group as={Col}>
                                <Form.Label>Gazoil Consommation</Form.Label>
                                <Form.Control
                                    type="number"
                                    placeholder="Consommation Gazoil"
                                    value={formData.consommation_gazoil}
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
                                            consommation_gazoil: target.value
                                        });
                                    }}
                                />
                            </Form.Group>
                            <Form.Group as={Col}>
                                <Form.Label>Gazoil Transfert</Form.Label>
                                <Form.Control
                                    type="number"
                                    placeholder="Transfert Gazoil"
                                    value={formData.transfert_gazoil}
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
                                            transfert_gazoil: target.value
                                        });
                                    }}
                                />
                            </Form.Group>
                            <Form.Group as={Col}>
                                <Form.Label>Production Gazoil</Form.Label>
                                <Form.Control
                                    type="number"
                                    placeholder="Production Gazoil"
                                    value={formData.production_gazoil}
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
                                            production_gazoil: target.value
                                        });
                                    }}
                                />
                            </Form.Group>
                        </Form.Row>
                    )}
                    {selectedCentrale.subtype === "+charbon" && (
                        <Form.Row>
                            <Form.Group as={Col}>
                                <Form.Label>Charbon Livraison</Form.Label>
                                <Form.Control
                                    type="number"
                                    placeholder="Charbon Livraison"
                                    value={formData.livraison_charbon}
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
                                            livraison_charbon: target.value
                                        });
                                    }}
                                />
                            </Form.Group>
                            <Form.Group as={Col}>
                                <Form.Label>Charbon Consommation</Form.Label>
                                <Form.Control
                                    type="number"
                                    placeholder="Charbon Consommation"
                                    value={formData.consommation_charbon}
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
                                            consommation_charbon: target.value
                                        });
                                    }}
                                />
                            </Form.Group>
                            <Form.Group as={Col}>
                                <Form.Label>Charbon Transfert</Form.Label>
                                <Form.Control
                                    type="number"
                                    placeholder="Charbon Transfert"
                                    value={formData.transfert_charbon}
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
                                            transfert_charbon: target.value
                                        });
                                    }}
                                />
                            </Form.Group>
                        </Form.Row>
                    )}
                </>
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

export default TurbineGazForm;
