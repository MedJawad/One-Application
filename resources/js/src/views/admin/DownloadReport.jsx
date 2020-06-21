import React, { useState, useEffect } from "react";
import { Row, Col, Table, DropdownButton } from "react-bootstrap";
import { ClipLoader } from "react-spinners";
import Card from "../../components/Card/Card.jsx";
import Pagination from "../../components/Pagination/Pagination";
import { Link, Redirect } from "react-router-dom";
import fileDownload from "js-file-download";
import api from "../../API";

function DownloadReport() {
    const [isLoaded, setLoaded] = useState(false);

    const fetchFile = () => {
        //We do not need a globalized state for the FilesList view so we can just do our api call right here
        // api
        //   .get(`/locationFiles`)
        //   .then(res => (res.status === 200 ? res.data : console.log(res)))
        //   .then(data => {
        //     setFiles(data.locationFiles);
        //     setLoaded(true);
        //   })
        //   .catch(error => alert("Failed to fetch Data from Server " + error));
        api.get("/downloadReport", {
            responseType: "blob"
        })
            // .then((res) => res.blob())
            .then(res => {
                // console.log(res);
                fileDownload(res.data, "report.xlsx");
                return res;
            })
            .then(() => setLoaded(true));
        // .catch((err) => console.log(err))
        // .then(() => setLoaded(true));
    };

    useEffect(fetchFile, []);

    return isLoaded ? (
        <Redirect to="/" />
    ) : (
        <div className="content">
            <Row>
                <Col md={12}>
                    <Card
                        title="Please wait while your report is getting ready"
                        ctTableFullWidth
                        ctTableResponsive
                        content={
                            <>
                                {/* <a href="http://one.test/api/downloadReport" download>
                  download
                </a> */}
                                <ClipLoader
                                    size={150}
                                    css={{ display: "block", margin: "auto" }}
                                />
                            </>
                        }
                    />
                </Col>
            </Row>
        </div>
    );
}

export default DownloadReport;
