import React, { useState, useEffect } from "react";
import { Grid, Row, Col, Table, DropdownButton } from "react-bootstrap";
import { ClipLoader } from "react-spinners";
import Card from "../components/Card/Card.jsx";
import Pagination from "../components/Pagination/Pagination";
import { Link } from "react-router-dom";

import api from "./API";

function LocationFilesList() {
    const [files, setFiles] = useState([]);
    const [isLoaded, setLoaded] = useState(false);

    const fetchFiles = () => {
        //We do not need a globalized state for the FilesList view so we can just do our api call right here
        // api
        //   .get(`/locationFiles`)
        //   .then(res => (res.status === 200 ? res.data : console.log(res)))
        //   .then(data => {
        //     setFiles(data.locationFiles);
        //     setLoaded(true);
        //   })
        //   .catch(error => alert("Failed to fetch Data from Server " + error));
    };

    const resendFile = id => {
        setLoaded(false);
        api.post(`/locationFiles/${id}`).then(res =>
            res.status === 200 ? fetchFiles() : console.log(res)
        );
    };

    useEffect(fetchFiles, []);

    let thArray = [
        "id",
        "created_at",
        "error",
        "statut",
        "uploaded_at",
        "locations"
    ];
    //Pagination Logic
    const items = files;
    const [itemsPerPage] = useState(5);
    const [currentPage, setCurrentPage] = useState(1);
    const indexOfLastItem = currentPage * itemsPerPage;
    const indexOfFirstItem = indexOfLastItem - itemsPerPage;
    const currentItems = items.slice(indexOfFirstItem, indexOfLastItem);

    return isLoaded ? (
        <div className="content">
            <Grid fluid>
                <Row>
                    <Col md={12}>
                        <Card
                            title={`List of Location Files`}
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
                                            {currentItems.map((file, key) => {
                                                return (
                                                    <tr key={key}>
                                                        <td>{file[`id`]}</td>
                                                        <td>
                                                            {file[`created_at`]}
                                                        </td>
                                                        <td>{file[`error`]}</td>
                                                        <td
                                                            style={{
                                                                position:
                                                                    "relative"
                                                            }}
                                                        >
                                                            {file[`statut`] ===
                                                            "done" ? (
                                                                <ResendButton
                                                                    color="success"
                                                                    text="done"
                                                                    index={key}
                                                                    isDone={
                                                                        true
                                                                    }
                                                                />
                                                            ) : file[
                                                                  `statut`
                                                              ] === "sent" ? (
                                                                <ResendButton
                                                                    color="warning"
                                                                    text="sent"
                                                                    index={key}
                                                                    handleClick={() =>
                                                                        resendFile(
                                                                            file[
                                                                                "id"
                                                                            ]
                                                                        )
                                                                    }
                                                                />
                                                            ) : file[
                                                                  `statut`
                                                              ] === "failed" ? (
                                                                <ResendButton
                                                                    color="danger"
                                                                    text="failed"
                                                                    index={key}
                                                                    handleClick={() =>
                                                                        resendFile(
                                                                            file[
                                                                                "id"
                                                                            ]
                                                                        )
                                                                    }
                                                                />
                                                            ) : file[
                                                                  `statut`
                                                              ] ===
                                                              "created" ? (
                                                                <ResendButton
                                                                    color="primary"
                                                                    text="created"
                                                                    index={key}
                                                                    handleClick={() =>
                                                                        resendFile(
                                                                            file[
                                                                                "id"
                                                                            ]
                                                                        )
                                                                    }
                                                                />
                                                            ) : (
                                                                ""
                                                            )}
                                                        </td>
                                                        <td>
                                                            {
                                                                file[
                                                                    `uploaded_at`
                                                                ]
                                                            }
                                                        </td>
                                                        <td>
                                                            <Link
                                                                className="btn btn-primary btn-fill"
                                                                to={`/admin/locationfiles/${
                                                                    file[`id`]
                                                                }/locations`}
                                                            >
                                                                View Locations
                                                            </Link>
                                                        </td>
                                                    </tr>
                                                );
                                            })}
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
                            title="List of Location Files"
                            category="Last 50 Files"
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

export default LocationFilesList;

const ResendButton = ({ index, color, text, isDone, handleClick }) => {
    return (
        <DropdownButton
            id={`dropdown-basic-${index}`}
            className="btn-fill"
            bsStyle={color}
            title={text}
            noCaret={true}
        >
            {isDone ? (
                <div style={{ display: "none" }}></div>
            ) : (
                <div
                    className={`btn btn-warning btn-fill`}
                    style={{
                        display: "block"
                    }}
                    onClick={() => handleClick()}
                >
                    Resend File <i className="pe-7s-refresh-2"></i>
                </div>
            )}
        </DropdownButton>
    );
};
