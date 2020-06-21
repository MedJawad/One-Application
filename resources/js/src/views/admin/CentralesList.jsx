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
// import moduleName from 'pagin';
import { ClipLoader } from "react-spinners";
import qs from "querystring";

import api from "../../API";
import CustomPagination from "../../components/Pagination/Pagination";
import { Link } from "react-router-dom";

const CentralesList = ({ type }) => {
    const [centrales, setCentrales] = useState([]);
    const [isLoaded, setLoaded] = useState(false);

    const fetchCentrales = () => {
        api.get(`/centrales?type=${type || ""}`)
            .then(res => (res.status === 200 ? res.data : null))
            .then(data => {
                setCentrales(data.centrales);
                // console.log(data);
                setLoaded(true);
            })
            .catch(error => alert("Failed to fetch Data from Server " + error));
    };
    useEffect(fetchCentrales, []);

    const items = centrales;
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
                                <Card.Title>Liste des Centrales</Card.Title>
                                {isLoaded ? (
                                    <>
                                        <Table responsive>
                                            <thead>
                                                <tr>
                                                    {/* <th>id</th> */}
                                                    <th>nom</th>
                                                    <th>type</th>
                                                    <th>subtype</th>
                                                    {/* <th>adresse</th>
                          <th>description</th> */}
                                                    <th>Username</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                {currentItems.map(
                                                    (item, index) => (
                                                        <tr key={index}>
                                                            {/* <td>{item.id}</td> */}
                                                            <td>{item.nom}</td>
                                                            <td>{item.type}</td>
                                                            <td>
                                                                {item.subtype}
                                                            </td>
                                                            {/* <td>{item.adresse}</td>
                            <td>{item.description}</td> */}
                                                            <td>
                                                                {
                                                                    item.user
                                                                        .username
                                                                }
                                                            </td>
                                                            <td>
                                                                <Link
                                                                    to={`/admin/centrales/${item.id}`}
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

export default CentralesList;
