import React, { useState, useEffect } from "react";
import { Grid, Row, Col, Table } from "react-bootstrap";
import { ClipLoader } from "react-spinners";
import Card from "../components/Card/Card.jsx";
import Pagination from "../components/Pagination/Pagination";
import { Link } from "react-router-dom";

import api from "./API";

function AnswersList(props) {
    const review_id = props.match.params.review_id;
    const [review, setReview] = useState({});
    const [isLoaded, setLoaded] = useState(false);

    const fetchFile = review_id => {
        //We do not need a globalized state for the File view so we can just do our api call right here
        // api
        //   .get(`/reviews/${review_id}/answers`)
        //   .then(res => (res.status === 200 ? res.data : console.log(res)))
        //   .then(data => {
        //     setReview(data.review);
        //     setLoaded(true);
        //   })
        //   .catch(error => alert("Failed to fetch Data from Server " + error));
    };

    useEffect(() => fetchFile(review_id), [review_id]); //Uncomment this to enable fetching reviews from API

    const items = isLoaded && review.answers;
    const [itemsPerPage] = useState(25);
    const [currentPage, setCurrentPage] = useState(1);
    const indexOfLastItem = currentPage * itemsPerPage;
    const indexOfFirstItem = indexOfLastItem - itemsPerPage;
    const currentItems = isLoaded
        ? items.slice(indexOfFirstItem, indexOfLastItem)
        : [];

    const thArray = [
        "id",
        "message",
        "created_at",
        "updated_at",
        "user",
        "review"
    ];

    return isLoaded ? (
        <div className="content">
            <Grid fluid>
                <Row>
                    <Col md={12}>
                        <Card
                            title={`List of Answers for the Review ${isLoaded &&
                                review_id}`}
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
                                            {currentItems.map((answer, key) => {
                                                return (
                                                    <tr key={key}>
                                                        <td>{answer["id"]}</td>
                                                        <td>
                                                            {answer["message"]}
                                                        </td>
                                                        <td>
                                                            {
                                                                answer[
                                                                    "created_at"
                                                                ]
                                                            }
                                                        </td>
                                                        <td>
                                                            {
                                                                answer[
                                                                    "updated_at"
                                                                ]
                                                            }
                                                        </td>
                                                        <td>
                                                            <Link
                                                                className="btn btn-primary btn-fill"
                                                                to={`/admin/users/${answer["user_id"]}`}
                                                            >
                                                                View User
                                                            </Link>
                                                        </td>
                                                        <td>
                                                            <Link
                                                                className="btn btn-primary btn-fill"
                                                                to={`/admin/locations/${answer["review_id"]}`}
                                                            >
                                                                View Review
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
                            title={`List of Answers of the review ${isLoaded &&
                                review_id}`}
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

export default AnswersList;
