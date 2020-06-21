import React from "react";
import { Row, Col, Button } from "react-bootstrap";
import { useState } from "react";
import ProductionsForm from "./forms/ProductionsForm";
import PrevisionsForm from "./forms/PrevisionsForm";

const FormChoose = props => {
    const [type, setType] = useState();

    switch (type) {
        case "productions":
            return <ProductionsForm {...props} />;
            break;
        case "previsions":
            return <PrevisionsForm {...props} />;
            break;
        default:
            return (
                <Row>
                    <Col md={{ span: 5 }}>
                        <Button
                            className="col-md-12"
                            onClick={() => setType("productions")}
                        >
                            Productions
                        </Button>
                    </Col>
                    <Col md={{ span: 5, offset: 2 }}>
                        <Button
                            className="col-md-12"
                            onClick={() => setType("previsions")}
                        >
                            Previsions
                        </Button>
                    </Col>
                </Row>
            );
            break;
    }
};

export default FormChoose;
