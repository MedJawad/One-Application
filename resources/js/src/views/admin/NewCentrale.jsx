import React, { useEffect, useState } from "react";

import { Row, Col, Container, Card, Button, Form } from "react-bootstrap";

import { ClipLoader } from "react-spinners";
import qs from "querystring";

import api from "../../API";

const NewCentrale = () => {
    const initialState = {
        type: "",
        subtype: "normal",
        nom: "",
        username: "",
        password: "",
        c_password: "",
        adresse: "",
        description: ""
    };
    const [isLoading, setisLoading] = useState(false);
    const [isSubmitted, setSubmitted] = useState(false);
    const [formData, setFormData] = useState(initialState);

    const handleFormSubmit = e => {
        e.preventDefault();
        // console.log(formData);
        setisLoading(true);
        const centraleRequestOptions = {
            method: "POST",
            url: `/centrales`,
            data: qs.stringify(formData),
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            json: true
        };
        setFormData(initialState);
        api(centraleRequestOptions)
            .then(res => {
                // console.log(res);
                setSubmitted(true);
                setTimeout(() => setSubmitted(false), 2000);
            })
            // .then(res => console.log(res))
            .catch(error => {
                // console.log(error);
            })
            .then(() => setisLoading(false));
    };

    return (
        <div className="content">
            <Container>
                <Row>
                    <Col md={12}>
                        <Card md={12}>
                            <Card.Body>
                                {isSubmitted && (
                                    <Card.Title>
                                        <div className="alert alert-success  text-center">
                                            Centrale a été créée correctement !
                                        </div>
                                    </Card.Title>
                                )}
                                <Card.Title>
                                    Veuillez remplir les informations suivantes
                                    pour créer une nouvelle centrale:
                                </Card.Title>
                                <Form onSubmit={handleFormSubmit}>
                                    <Form.Row>
                                        <Form.Group as={Col}>
                                            <Form.Label>Type</Form.Label>
                                            <Form.Control
                                                as="select"
                                                value={
                                                    formData.type || "default"
                                                }
                                                onChange={evt =>
                                                    setFormData({
                                                        ...formData,
                                                        type: evt.target.value
                                                    })
                                                }
                                            >
                                                <option
                                                    value="default"
                                                    disabled
                                                >
                                                    Choisissez le type de la
                                                    centrale que vous voulez
                                                    ajouter
                                                </option>
                                                <option value="Barrage">
                                                    Barrage
                                                </option>
                                                <option value="Eolien">
                                                    Parc Eolien
                                                </option>
                                                <option value="Solaire">
                                                    Energie Solaire
                                                </option>
                                                <option value="Thermique a charbon">
                                                    Thermique a charbon
                                                </option>
                                                <option value="Turbine a gaz">
                                                    Turbine a gaz
                                                </option>
                                                <option value="Cycle Combine">
                                                    Cycle Combiné
                                                </option>
                                                <option value="Interconnexions">
                                                    Interconnexion
                                                </option>
                                            </Form.Control>
                                        </Form.Group>
                                        <Form.Group as={Col}>
                                            <Form.Label>Sous-Type</Form.Label>
                                            <Form.Control
                                                as="select"
                                                value={
                                                    formData.subtype || "normal"
                                                }
                                                onChange={evt =>
                                                    setFormData({
                                                        ...formData,
                                                        subtype:
                                                            evt.target.value
                                                    })
                                                }
                                            >
                                                <option value="normal">
                                                    normal
                                                </option>
                                                {formData.type ===
                                                    "Barrage" && (
                                                    <>
                                                        <option value="+cote">
                                                            A 2 Cotes
                                                        </option>
                                                        <option value="-cote">
                                                            Sans Cotes
                                                        </option>
                                                        <option value="onlyVolumePompe">
                                                            Seulement Volume
                                                            Pompé
                                                        </option>
                                                        <option value="onlyProductionCote">
                                                            Seulement Production
                                                            et Cote
                                                        </option>
                                                    </>
                                                )}
                                                {formData.type ===
                                                    "Thermique a charbon" && (
                                                    <>
                                                        <option value="-autonomie">
                                                            Sans autonomie
                                                            charbon
                                                        </option>
                                                    </>
                                                )}
                                            </Form.Control>
                                        </Form.Group>
                                    </Form.Row>
                                    <Form.Row>
                                        <Form.Group as={Col}>
                                            <Form.Label>
                                                Nom de la centrale
                                            </Form.Label>
                                            <Form.Control
                                                type="text"
                                                placeholder="Nom de centrale"
                                                required
                                                value={formData.nom || ""}
                                                onChange={evt =>
                                                    setFormData({
                                                        ...formData,
                                                        nom: evt.target.value
                                                    })
                                                }
                                            />
                                        </Form.Group>
                                        <Form.Group as={Col}>
                                            <Form.Label>Username</Form.Label>
                                            <Form.Control
                                                type="text"
                                                placeholder="Username pour se connecter à la centrale"
                                                required
                                                value={formData.username || ""}
                                                onChange={evt =>
                                                    setFormData({
                                                        ...formData,
                                                        username:
                                                            evt.target.value
                                                    })
                                                }
                                            />
                                        </Form.Group>
                                        <Form.Group as={Col}>
                                            <Form.Label>Password</Form.Label>
                                            <Form.Control
                                                type="password"
                                                placeholder="Mot de passe pour se connecter à la centrale"
                                                required
                                                value={formData.password || ""}
                                                onChange={evt =>
                                                    setFormData({
                                                        ...formData,
                                                        password:
                                                            evt.target.value
                                                    })
                                                }
                                            />
                                        </Form.Group>
                                        <Form.Group as={Col}>
                                            <Form.Label>
                                                Confirm Password
                                            </Form.Label>
                                            <Form.Control
                                                type="password"
                                                placeholder="Retapez le mot de passe"
                                                required
                                                value={
                                                    formData.c_password || ""
                                                }
                                                onChange={evt =>
                                                    setFormData({
                                                        ...formData,
                                                        c_password:
                                                            evt.target.value
                                                    })
                                                }
                                            />
                                        </Form.Group>
                                    </Form.Row>
                                    <Form.Row>
                                        <Form.Group as={Col}>
                                            <Form.Label>Adresse</Form.Label>
                                            <Form.Control
                                                type="text"
                                                placeholder="Adresse de la centrale"
                                                value={formData.adresse || ""}
                                                onChange={evt =>
                                                    setFormData({
                                                        ...formData,
                                                        adresse:
                                                            evt.target.value
                                                    })
                                                }
                                            />
                                        </Form.Group>
                                        <Form.Group as={Col}>
                                            <Form.Label>Description</Form.Label>
                                            <Form.Control
                                                type="text"
                                                placeholder="Description de la centrale"
                                                value={
                                                    formData.description || ""
                                                }
                                                onChange={evt =>
                                                    setFormData({
                                                        ...formData,
                                                        description:
                                                            evt.target.value
                                                    })
                                                }
                                            />
                                        </Form.Group>
                                    </Form.Row>
                                    <Form.Row>
                                        {isLoading ? (
                                            <Col md={{ span: 2, offset: 10 }}>
                                                <ClipLoader className="btn-fill ml-auto" />
                                            </Col>
                                        ) : (
                                            <Button
                                                variant="primary"
                                                type="submit"
                                                className="btn-fill ml-auto"
                                                // onClick={handleFormSubmit}
                                            >
                                                Valider
                                            </Button>
                                        )}
                                    </Form.Row>
                                </Form>
                            </Card.Body>
                        </Card>
                    </Col>
                </Row>
            </Container>
        </div>
    );
};

export default NewCentrale;
