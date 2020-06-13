import React, { useState, useEffect } from "react";
import { Grid, Row, Col } from "react-bootstrap";

import { Card } from "../components/Card/Card.jsx";
import { FormInputs } from "../components/FormInputs/FormInputs.jsx";

import { ClipLoader } from "react-spinners";

import api from "./API";

function LocationView(props) {
    const location_id = props.match.params.location_id;
    const [location, setLocation] = useState(null);
    const [isLoaded, setLoaded] = useState(false);

    const fetchLocation = location_id => {
        //We do not need a globalized state for the LocationsList view so we can just do our api call right here
        // api
        //   .get(`/locations/${location_id}`)
        //   .then(res => (res.status === 200 ? res.data : console.log(res)))
        //   .then(data => {
        //     data && setLocation(data);
        //     data && setLoaded(true);
        //   })
        //   .catch(error => alert(error));
    };

    useEffect(() => fetchLocation(location_id), [location_id]);

    return (
        <div className="content">
            <Grid fluid>
                <Row>
                    <Col md={10} mdOffset={1}>
                        <Card
                            title={`Location ${location_id}`}
                            category=""
                            ctTableFullWidth
                            ctTableResponsive
                            content={
                                isLoaded ? (
                                    <Row>
                                        <Col md={10} mdOffset={1}>
                                            <FormInputs
                                                ncols={[
                                                    "col-md-5",
                                                    "col-md-3",
                                                    "col-md-4"
                                                ]}
                                                properties={[
                                                    {
                                                        label: "ID",
                                                        type: "text",
                                                        bsClass: "form-control",
                                                        defaultValue: location_id,
                                                        disabled: true
                                                    },
                                                    {
                                                        label: "Name",
                                                        type: "text",
                                                        bsClass: "form-control",
                                                        defaultValue:
                                                            location.name,
                                                        disabled: true
                                                    },
                                                    {
                                                        label: "Siret",
                                                        type: "text",
                                                        bsClass: "form-control",
                                                        defaultValue:
                                                            location.siret,
                                                        disabled: true
                                                    }
                                                ]}
                                            />
                                            <FormInputs
                                                ncols={["col-md-6", "col-md-6"]}
                                                properties={[
                                                    {
                                                        label: "Street Number",
                                                        type: "text",
                                                        bsClass: "form-control",
                                                        defaultValue:
                                                            location.street_number,
                                                        disabled: true
                                                    },
                                                    {
                                                        label: "Postal Code",
                                                        type: "text",
                                                        bsClass: "form-control",
                                                        defaultValue:
                                                            location.postal_code,
                                                        disabled: true
                                                    }
                                                ]}
                                            />
                                            <FormInputs
                                                ncols={[
                                                    "col-md-4",
                                                    "col-md-4",
                                                    "col-md-4"
                                                ]}
                                                properties={[
                                                    {
                                                        label: "Adress",
                                                        type: "text",
                                                        bsClass: "form-control",
                                                        defaultValue:
                                                            location.adress,
                                                        disabled: true
                                                    },
                                                    {
                                                        label: "City",
                                                        type: "text",
                                                        bsClass: "form-control",
                                                        defaultValue:
                                                            location.city,
                                                        disabled: true
                                                    },
                                                    {
                                                        label: "Phone Number",
                                                        type: "text",
                                                        bsClass: "form-control",
                                                        defaultValue:
                                                            location.phone_number,
                                                        disabled: true
                                                    }
                                                ]}
                                            />
                                            <FormInputs
                                                ncols={[
                                                    "col-md-4",
                                                    "col-md-4",
                                                    "col-md-4"
                                                ]}
                                                properties={[
                                                    {
                                                        label: "Created At",
                                                        type: "text",
                                                        bsClass: "form-control",
                                                        defaultValue: location.created_at
                                                            .slice(
                                                                0,
                                                                location.created_at.indexOf(
                                                                    "."
                                                                )
                                                            )
                                                            .replace("T", " "),
                                                        disabled: true
                                                    },
                                                    {
                                                        label: "Updated At",
                                                        type: "text",
                                                        bsClass: "form-control",
                                                        defaultValue: location.updated_at
                                                            .slice(
                                                                0,
                                                                location.updated_at.indexOf(
                                                                    "."
                                                                )
                                                            )
                                                            .replace("T", " "),
                                                        disabled: true
                                                    },
                                                    {
                                                        label: "Deleted At",
                                                        type: "text",
                                                        bsClass: "form-control",
                                                        defaultValue:
                                                            location.deleted_at,
                                                        disabled: true
                                                    }
                                                ]}
                                            />
                                        </Col>
                                    </Row>
                                ) : (
                                    <ClipLoader
                                        size={150}
                                        css={{
                                            display: "block",
                                            margin: "auto"
                                        }}
                                    />
                                )
                            }
                        />
                    </Col>
                </Row>
            </Grid>
        </div>
    );
}

export default LocationView;
