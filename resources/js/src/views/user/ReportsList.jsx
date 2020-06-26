import React, { useEffect, useState } from "react";

import {
    Row,
    Col,
    Container,
    Card,
    Button,
    Form,
    Table
} from "react-bootstrap";
import { ClipLoader } from "react-spinners";
import qs from "querystring";

import api from "../../API";
import CustomPagination from "../../components/Pagination/Pagination";
import { Link } from "react-router-dom";

const ReportsList = ({ type }) => {
    const [reports, setReports] = useState([]);
    const [isLoaded, setLoaded] = useState(false);

    const fetchReports = () => {
        api.get(`/reports`)
            .then(res => (res.status === 200 ? res.data : null))
            .then(data => {
                setReports(data.reports);
                // console.log(data);
            })
            .catch(error => alert("Failed to fetch Data from Server " + error))
            .then(() => setLoaded(true));
    };
    useEffect(fetchReports, []);

    const items = reports;
    const [itemsPerPage] = useState(5);
    const [currentPage, setCurrentPage] = useState(1);
    const indexOfLastItem = currentPage * itemsPerPage;
    const indexOfFirstItem = indexOfLastItem - itemsPerPage;
    const currentItems = items.slice(indexOfFirstItem, indexOfLastItem);

    return (
        <div className="content">
            <Container>
                <Row>
                    <Col md={12}>
                        <Card md={12}>
                            <Card.Body>
                                <Card.Title>
                                    Liste des Rapports de la derniere 24H
                                </Card.Title>
                                {isLoaded ? (
                                    <>
                                        <Table responsive>
                                            <thead>
                                                <tr>
                                                    {/* <th>id</th> */}
                                                    <th>Date</th>
                                                    <th>Horaire</th>
                                                    <th>
                                                        Derniere Modification
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                {currentItems.map(
                                                    (item, index) => (
                                                        <tr key={index}>
                                                            {/* <td>{item.id}</td> */}
                                                            <td>{item.date}</td>
                                                            <td>
                                                                {item.horaire}
                                                            </td>
                                                            <td>
                                                                {(
                                                                    "" +
                                                                    item.updated_at
                                                                )
                                                                    .split(
                                                                        "."
                                                                    )[0]
                                                                    .replace(
                                                                        "T",
                                                                        " "
                                                                    )}
                                                            </td>
                                                            <td>
                                                                <Link
                                                                    to={`/admin/reports/${item.id}`}
                                                                >
                                                                    <Button>
                                                                        Edit
                                                                    </Button>
                                                                </Link>
                                                            </td>
                                                        </tr>
                                                    )
                                                )}
                                            </tbody>
                                        </Table>
                                        <Col md={{ span: 4, offset: 4 }}>
                                            <CustomPagination
                                                itemsPerPage={itemsPerPage}
                                                totalItems={items.length}
                                                currentPage={currentPage}
                                                setCurrentPage={setCurrentPage}
                                            />
                                        </Col>
                                    </>
                                ) : (
                                    <Col md={{ span: 4, offset: 5 }}>
                                        <ClipLoader size={200} />
                                    </Col>
                                )}
                            </Card.Body>
                        </Card>
                    </Col>
                </Row>
            </Container>
        </div>
    );
};

export default ReportsList;
