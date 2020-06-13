import React, { useState, useEffect } from "react";
import { Grid, Row, Col, Table } from "react-bootstrap";
import { ClipLoader } from "react-spinners";
import Card from "../components/Card/Card.jsx";
import Pagination from "../components/Pagination/Pagination";
import { Link } from "react-router-dom";

import api from "./API";

function ReviewsList(props) {
    const file_id = props.match.params.file_id;
    const [file, setFile] = useState({});
    const [isLoaded, setLoaded] = useState(false);

    const fetchFile = file_id => {
        //We do not need a globalized state for the File view so we can just do our api call right here
        // api
        //   .get(`/reviewFiles/${file_id}/reviews`)
        //   .then((res) => (res.status === 200 ? res.data : console.log(res)))
        //   .then((data) => {
        //     setFile(data.reviewFile);
        //     setLoaded(true);
        //   })
        //   .catch((error) => alert("Failed to fetch Data from Server " + error));
    };

    useEffect(() => fetchFile(file_id), [file_id]); //Uncomment this to enable fetching files from API
    // useEffect(() => {
    //   setLoaded(true);
    //   console.log(reviewsData);
    // });
    //Pagination Logic
    //   const items = isLoaded && file.reviews;
    const items = isLoaded && file.reviews;
    const [itemsPerPage] = useState(25);
    const [currentPage, setCurrentPage] = useState(1);
    const indexOfLastItem = currentPage * itemsPerPage;
    const indexOfFirstItem = indexOfLastItem - itemsPerPage;
    const currentItems = isLoaded
        ? items.slice(indexOfFirstItem, indexOfLastItem)
        : [];

    const thArray = [
        "id",
        "subject",
        // "message",
        "experience_start",
        "experience_end",
        "created_at",
        "rating_note",
        "user",
        "location",
        "answers"
        // "updated_at",
        // "deleted_at"
    ];

    return isLoaded ? (
        <div className="content">
            <Grid fluid>
                {/* <Row>
          <Col lg={4} sm={6}>
            <StatsCard
              bigIcon={<i className="pe-7s-map-marker text-warning" />}
              statsText="Reviews Sent"
              statsValue={file.reviews_count}
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
              bigIcon={<i className="pe-7s-attention text-danger" />}
              statsText="Douteux"
              statsValue={file.doutCount}
              // statsIcon={<i className="fa fa-clock-o" />}
              // statsIconText="In the last hour"
            />
          </Col>
        </Row> */}
                <Row>
                    <Col md={12}>
                        <Card
                            title={`List of Reviews in The File ${false &&
                                file.created_at}`}
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
                                            {currentItems.map((review, key) => {
                                                return (
                                                    <tr key={key}>
                                                        <td>{review["id"]}</td>
                                                        <td>
                                                            {review["subject"]}
                                                        </td>
                                                        <td>
                                                            {
                                                                review[
                                                                    "experience_start"
                                                                ]
                                                            }
                                                        </td>
                                                        <td>
                                                            {
                                                                review[
                                                                    "experience_end"
                                                                ]
                                                            }
                                                        </td>
                                                        <td>
                                                            {
                                                                review[
                                                                    "created_at"
                                                                ]
                                                            }
                                                        </td>
                                                        <td>
                                                            {
                                                                review[
                                                                    "rating_note"
                                                                ]
                                                            }
                                                        </td>
                                                        <td>
                                                            <Link
                                                                className="btn btn-primary btn-fill"
                                                                to={`/admin/users/${review["user_id"]}`}
                                                            >
                                                                View User
                                                            </Link>
                                                        </td>
                                                        <td>
                                                            <Link
                                                                className="btn btn-primary btn-fill"
                                                                to={`/admin/locations/${review["location_id"]}`}
                                                            >
                                                                View Location
                                                            </Link>
                                                        </td>
                                                        <td>
                                                            <Link
                                                                className="btn btn-primary btn-fill"
                                                                to={`/admin/reviews/${review["id"]}/answers`}
                                                            >
                                                                View Answers
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
                            title={`List of Reviews in The File ${isLoaded &&
                                file_id}`}
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

export default ReviewsList;
