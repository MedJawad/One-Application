import React, { useState, useEffect } from "react";
import { Grid, Row, Col, Table } from "react-bootstrap";
import { ClipLoader } from "react-spinners";
import Card from "../components/Card/Card.jsx";
import Pagination from "../components/Pagination/Pagination";
import StatsCard from "../components/StatsCard/StatsCard";

import api from "./API";

function LocationsList(props) {
    const file_id = props.match.params.file_id;
    const [file, setFile] = useState({});
    const [isLoaded, setLoaded] = useState(false);

    const fetchFile = file_id => {
        //We do not need a globalized state for the File view so we can just do our api call right here
        // api
        //   .get(`/locationFiles/${file_id}/locations`)
        //   .then(res => (res.status === 200 ? res.data : console.log(res)))
        //   .then(data => {
        //     setFile(data.locationFile);
        //     setLoaded(true);
        //   })
        //   .catch(error => alert("Failed to fetch Data from Server " + error));
    };

    useEffect(() => fetchFile(file_id), [file_id]);

    //Pagination Logic
    const items = isLoaded && file.locations;
    const [itemsPerPage] = useState(25);
    const [currentPage, setCurrentPage] = useState(1);
    const indexOfLastItem = currentPage * itemsPerPage;
    const indexOfFirstItem = indexOfLastItem - itemsPerPage;
    const currentItems = isLoaded
        ? items.slice(indexOfFirstItem, indexOfLastItem)
        : [];

    const thArray = [
        "id",
        "type",
        "name",
        "resultat",
        "siret",
        "adress",
        "postal_code",
        "city",
        "phone_number",
        "sync_pj",
        "created_at",
        "updated_at"
    ];

    return isLoaded ? (
        <div className="content">
            <Grid fluid>
                <Row>
                    <Col lg={4} sm={6}>
                        <StatsCard
                            bigIcon={
                                <i className="pe-7s-map-marker text-warning" />
                            }
                            statsText="Locations Sent"
                            statsValue={file.locations_count}
                            statsIcon={<i className="fa fa-refresh" />}
                            statsIconText={`Uploaded at : ${file.uploaded_at}`}
                        />
                    </Col>
                    <Col lg={4} sm={6}>
                        <StatsCard
                            bigIcon={<i className="pe-7s-check text-success" />}
                            statsText="Published"
                            statsValue={file.pubCount}
                            // statsIcon={<i className="fa fa-calendar-o" />}
                            // statsIconText="Last day"
                        />
                    </Col>
                    <Col lg={4} sm={6}>
                        <StatsCard
                            bigIcon={
                                <i className="pe-7s-attention text-danger" />
                            }
                            statsText="Douteux"
                            statsValue={file.doutCount}
                            // statsIcon={<i className="fa fa-clock-o" />}
                            // statsIconText="In the last hour"
                        />
                    </Col>
                </Row>
                <Row>
                    <Col md={12}>
                        <Card
                            title={`List of Locations in The File ${file.created_at}`}
                            category=""
                            ctTableFullWidth
                            ctTableResponsive
                            content={
                                <React.Fragment>
                                    <Table hover>
                                        <thead>
                                            <tr>
                                                {thArray.map((prop, key) => {
                                                    return (
                                                        <th key={key}>
                                                            {prop}
                                                        </th>
                                                    );
                                                })}
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {currentItems.map(
                                                (location, key) => {
                                                    return (
                                                        <tr key={key}>
                                                            <td>
                                                                {location["id"]}
                                                            </td>
                                                            <td>
                                                                {
                                                                    location[
                                                                        "type"
                                                                    ]
                                                                }
                                                            </td>
                                                            <td>
                                                                {
                                                                    location[
                                                                        "name"
                                                                    ]
                                                                }
                                                            </td>
                                                            <td>
                                                                {location.pivot
                                                                    .resultat ===
                                                                "pub" ? (
                                                                    <div className="label label-success">
                                                                        published
                                                                    </div>
                                                                ) : location
                                                                      .pivot
                                                                      .resultat ===
                                                                  "douteux" ? (
                                                                    <div className="label label-danger">
                                                                        douteux
                                                                    </div>
                                                                ) : (
                                                                    <div className="label label-warning">
                                                                        no
                                                                        result
                                                                    </div>
                                                                )}
                                                            </td>
                                                            <td>
                                                                {
                                                                    location[
                                                                        "siret"
                                                                    ]
                                                                }
                                                            </td>
                                                            <td>
                                                                {
                                                                    location[
                                                                        "adress"
                                                                    ]
                                                                }
                                                            </td>
                                                            <td>
                                                                {
                                                                    location[
                                                                        "postal_code"
                                                                    ]
                                                                }
                                                            </td>
                                                            <td>
                                                                {
                                                                    location[
                                                                        "city"
                                                                    ]
                                                                }
                                                            </td>
                                                            <td>
                                                                {
                                                                    location[
                                                                        "phone_number"
                                                                    ]
                                                                }
                                                            </td>
                                                            <td>
                                                                {
                                                                    location[
                                                                        "sync_pj"
                                                                    ]
                                                                }
                                                            </td>
                                                            <td>
                                                                {
                                                                    location[
                                                                        "created_at"
                                                                    ]
                                                                }
                                                            </td>
                                                            <td>
                                                                {
                                                                    location[
                                                                        "updated_at"
                                                                    ]
                                                                }
                                                            </td>
                                                        </tr>
                                                    );
                                                }
                                            )}
                                        </tbody>
                                    </Table>
                                    <Pagination
                                        itemsPerPage={itemsPerPage}
                                        totalItems={items.length}
                                        currentPage={currentPage}
                                        setCurrentPage={setCurrentPage}
                                    />
                                </React.Fragment>
                            }
                        />
                    </Col>
                </Row>
            </Grid>
        </div>
    ) : (
        <div className="content">
            <Grid fluid>
                <Row>
                    <Col md={12}>
                        <Card
                            title={`List of Locations in The File ${file_id}`}
                            category=""
                            ctTableFullWidth
                            ctTableResponsive
                            content={
                                <ClipLoader
                                    size={150}
                                    css={{ display: "block", margin: "auto" }}
                                />
                            }
                        />
                    </Col>
                </Row>
            </Grid>
        </div>
    );
}

export default LocationsList;
