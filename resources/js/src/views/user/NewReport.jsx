import React, { useEffect, useState } from "react";

import { Row, Col, Container, Card, Button, Form } from "react-bootstrap";

import { ClipLoader } from "react-spinners";

import api from "../../API";
import BarrageForm from "./forms/BarrageForm";
import ThermiqueCharbonForm from "./forms/ThermiqueCharbonForm";
import CycleCombineForm from "./forms/CycleCombineForm";

import FormChoose from "./FormChoose";

function NewReport() {
    const [error, setError] = useState("");

    const [isLoaded, setLoaded] = useState(false);
    const [isSubmitted, setSubmitted] = useState(false);
    const [selectedCentrale, setSelectedCentrale] = useState({
        type: "",
        subtype: "",
        nom: "",
        horaire: "",
        date: "",
        lastHourAdded: false
    });

    useEffect(() => {
        setLoaded(false);
        api.get("/newReport")
            .then(res => {
                // console.log(res);

                setSelectedCentrale(res.data.centrale);
                res.status === 230 &&
                    setSelectedCentrale(oldState => {
                        return { ...oldState, lastHourAdded: true };
                    });
                return res;
            })

            .catch(err => setError(err))
            .then(() => setLoaded(true));

        setTimeout(() => setSubmitted(false), 2000);
    }, [isSubmitted]);
    // console.log(selectedCentrale);
    const handleFormSubmit = (e, formData) => {
        e.preventDefault();
        setLoaded(false);
        const data = JSON.stringify(formData);
        // console.log("NEW REPORT : " + data);

        const newReportOptions = {
            method: "POST",
            url: `/reports`,
            data: data
        };
        api(newReportOptions)
            .then(res => {
                // console.log(res);
                res.status === 200 && setSubmitted(true);
                setLoaded(true);
            })
            .catch(error => {
                setError(error);
                setSubmitted(false);
                setLoaded(true);
            });
    };
    useEffect(() => {
        let handle;
        if (error !== "") handle = setTimeout(() => setError(""), 2000);
        return () => {
            clearTimeout(handle);
        };
    }, [error]);
    return (
        <div className="content">
            <Container>
                <Row>
                    <Col md={12}>
                        <Card md={12}>
                            {isSubmitted && (
                                <Card.Title>
                                    <div className="alert alert-success  text-center">
                                        Le rapport a été correctement créé
                                    </div>
                                </Card.Title>
                            )}
                            {error !== "" && (
                                <Card.Title>
                                    <div className="alert alert-danger  text-center">
                                        Une erreur a occuré
                                    </div>
                                </Card.Title>
                            )}
                            {isLoaded ? (
                                <Card.Body>
                                    {selectedCentrale.type === "Barrage" ? (
                                        <BarrageForm
                                            setLoaded={setLoaded}
                                            setSubmittedCorrectly={setSubmitted}
                                            selectedCentrale={selectedCentrale}
                                            handleFormSubmit={handleFormSubmit}
                                        />
                                    ) : selectedCentrale.type === "Eolien" ? (
                                        <FormChoose
                                            setLoaded={setLoaded}
                                            setSubmittedCorrectly={setSubmitted}
                                            selectedCentrale={selectedCentrale}
                                            handleFormSubmit={handleFormSubmit}
                                        />
                                    ) : selectedCentrale.type === "Solaire" ? (
                                        <FormChoose
                                            setLoaded={setLoaded}
                                            setSubmittedCorrectly={setSubmitted}
                                            horaire={
                                                selectedCentrale.horaire || ""
                                            }
                                            selectedCentrale={selectedCentrale}
                                            handleFormSubmit={handleFormSubmit}
                                        />
                                    ) : selectedCentrale.type ===
                                      "Cycle Combine" ? (
                                        <CycleCombineForm
                                            setLoaded={setLoaded}
                                            setSubmittedCorrectly={setSubmitted}
                                            selectedCentrale={selectedCentrale}
                                            handleFormSubmit={handleFormSubmit}
                                        />
                                    ) : selectedCentrale.type ===
                                      "Thermique a charbon" ? (
                                        <ThermiqueCharbonForm
                                            setLoaded={setLoaded}
                                            setSubmittedCorrectly={setSubmitted}
                                            selectedCentrale={selectedCentrale}
                                            handleFormSubmit={handleFormSubmit}
                                        />
                                    ) : (
                                        <h3>Invalid Centrale Type</h3>
                                    )}
                                </Card.Body>
                            ) : (
                                <Col md={{ span: 4, offset: 5 }}>
                                    <ClipLoader size={200} />
                                </Col>
                            )}
                        </Card>
                    </Col>
                </Row>
            </Container>
        </div>
    );
}

export default NewReport;
