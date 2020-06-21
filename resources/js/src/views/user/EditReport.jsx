import React, { useEffect, useState } from "react";

import { Row, Col, Container, Card, Button, Form } from "react-bootstrap";

import { ClipLoader } from "react-spinners";
import qs from "querystring";
import api from "../../API";
import BarrageForm from "./forms/BarrageForm";
import FormChoose from "./FormChoose";
import CycleCombineForm from "./forms/CycleCombineForm";
import ThermiqueCharbonForm from "./forms/ThermiqueCharbonForm";

const EditReport = props => {
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
    const report_id = props.match.params.report_id || "";
    useEffect(() => {
        const reportRequestOptions = {
            method: "get",
            url: `/reports/${report_id}`
        };
        api(reportRequestOptions)
            .then(res => {
                // console.log(res);
                setSelectedCentrale(res.data.centrale);
            })
            // .then(res => console.log(res))
            .catch(error => {
                // console.log(error);
                setError(error);
            })
            .then(() => setLoaded(true));
    }, []);
    useEffect(() => {
        let handle;
        if (error !== "") handle = setTimeout(() => setError(""), 2000);
        return () => {
            clearTimeout(handle);
        };
    }, [error]);
    // const handleFormSubmit = e => {
    //     e.preventDefault();
    //     // console.log(formData);
    //     setisLoading(true);

    //     const reportRequestOptions = {
    //         method: "PUT",
    //         url: `/reports/${report_id}`,
    //         data: qs.stringify(formData),
    //         headers: {
    //             "Content-Type": "application/x-www-form-urlencoded"
    //         },
    //         json: true
    //     };
    //     api(reportRequestOptions)
    //         .then(res => {
    //             // console.log(res);
    //             setSubmitted(true);
    //             setTimeout(() => setSubmitted(false), 2000);
    //         })
    //         // .then(res => console.log(res))
    //         .catch(error => {
    //             // console.log(error);
    //         })
    //         .then(() => setisLoading(false));
    // };
    const handleFormSubmit = (e, formData) => {
        e.preventDefault();
        setLoaded(false);
        const data = JSON.stringify(formData);
        // console.log(data);

        const newReportOptions = {
            method: "PUT",
            url: `/reports/${report_id}`,
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
    return (
        <div className="content">
            <Container>
                <Row>
                    <Col md={12}>
                        <Card md={12}>
                            {isSubmitted && (
                                <Card.Title>
                                    <div className="alert alert-success  text-center">
                                        Les informations du rapport ont été
                                        correctement modifié
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
                                            handleFormSubmit={handleFormSubmit}
                                            selectedCentrale={selectedCentrale}
                                        />
                                    ) : selectedCentrale.type ===
                                      "Cycle Combine" ? (
                                        <CycleCombineForm
                                            setLoaded={setLoaded}
                                            setSubmittedCorrectly={setSubmitted}
                                            handleFormSubmit={handleFormSubmit}
                                            selectedCentrale={selectedCentrale}
                                        />
                                    ) : selectedCentrale.type ===
                                      "Thermique a charbon" ? (
                                        <ThermiqueCharbonForm
                                            setLoaded={setLoaded}
                                            setSubmittedCorrectly={setSubmitted}
                                            handleFormSubmit={handleFormSubmit}
                                            selectedCentrale={selectedCentrale}
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
};

export default EditReport;
