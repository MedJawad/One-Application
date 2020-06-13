import React, { useEffect, useState } from "react";

import { Grid, Row, Col } from "react-bootstrap";

import { Card } from "../components/Card/Card.jsx";
import { StatsCard } from "../components/StatsCard/StatsCard";

import { ClipLoader } from "react-spinners";

import api from "./API";

function Dashboard() {
    const [latestLocationFile, setLatestLocationFile] = useState();
    const [lastMonthLocationFiles, setLastMonthLocationFiles] = useState([]);
    const [lastMonthLocationErrors, setLastMonthLocationErrors] = useState([]);

    const [latestReviewFiles, setLatestReviewFiles] = useState();
    const [lastMonthReviewFiles, setLastMonthReviewFiles] = useState([]);
    const [isLoaded, setLoaded] = useState(false);

    useEffect(() => {
        // api
        //   .get("/dashboard")
        //   .then((res) => (res.status === 200 ? res.data : console.log(res)))
        //   .then((data) => {
        //     setLatestLocationFile(data.locations.latestFile);
        //     setLastMonthLocationFiles(data.locations.lastMonthFiles);
        //     setLastMonthLocationErrors(data.locations.lastMonthErrors);
        //     setLatestReviewFiles(data.reviews.latestFiles);
        //     setLastMonthReviewFiles(data.reviews.lastMonthFiles);
        //     console.log(data.reviews);
        //     setLoaded(true);
        //   })
        //   .catch((error) => alert("Failed to fetch Data from Server " + error));
    }, []);

    // Data for Line Chart
    const dataSales = {
        locations: {
            labels: [],
            series: [[], []]
        },
        reviews: {
            labels: [],
            series: [[], []]
        }
    };

    let maxReviewsFileValue = 0;
    if (isLoaded) {
        lastMonthLocationFiles.map(file => {
            dataSales.locations.labels.push(file.uploaded_at.substring(5, 10));
            dataSales.locations.series[0].push(file.pubCount);
            dataSales.locations.series[1].push(file.doutCount);
            return null;
        });
        lastMonthReviewFiles.map(file => {
            dataSales.reviews.labels.push(file.date.substring(5, 10));
            dataSales.reviews.series[0].push(file.doneCount);
            dataSales.reviews.series[1].push(file.failedCount);
            return null;
        });

        for (let i = 0; i < lastMonthReviewFiles.length; i++) {
            lastMonthReviewFiles[i].count > maxReviewsFileValue &&
                (maxReviewsFileValue = lastMonthReviewFiles[i].count);
        }
    }
    const optionsSales = {
        locations: {
            low: 0,
            high: isLoaded ? latestLocationFile.locations_count : 1000,
            showArea: false,
            height: "245px",
            axisX: {
                showGrid: false
            },
            lineSmooth: true,
            showLine: true,
            showPoint: true,
            fullWidth: true,
            chartPadding: {
                right: 50
            }
        },
        reviews: {
            low: 0,
            high: isLoaded ? maxReviewsFileValue : 1000,
            showArea: false,
            height: "245px",
            axisX: {
                showGrid: false
            },
            lineSmooth: true,
            showLine: true,
            showPoint: true,
            fullWidth: true,
            chartPadding: {
                right: 50
            }
        }
    };
    const responsiveSales = [
        [
            "screen and (max-width: 640px)",
            {
                axisX: {
                    labelInterpolationFnc: function(value) {
                        return value[0];
                    }
                }
            }
        ]
    ];
    const legendSales = {
        locations: {
            names: ["Published", "Douteux"],
            types: ["info", "danger"]
        },
        reviews: {
            names: ["Done", "Failed"],
            types: ["info", "danger"]
        }
    };

    //DATA for Pie Chart
    const dataPie = {
        labels: [],
        series: []
    };
    const legendPie = {
        names: [],
        types: ["info", "danger", "warning", "success", "primary"]
    };
    if (isLoaded) {
        let totalCountOfErrors = 0;

        for (let error in lastMonthLocationErrors) {
            let count = lastMonthLocationErrors[error];
            totalCountOfErrors += count;
        }
        for (let error in lastMonthLocationErrors) {
            let percent = Math.floor(
                100 * (lastMonthLocationErrors[error] / totalCountOfErrors)
            );
            dataPie.labels.push(percent + "%");
            dataPie.series.push(percent);
            legendPie.names.push(error);
        }
    }
    return isLoaded ? (
        <div className="content">
            <Grid fluid>
                <div className="typo-line">
                    <h6>
                        <p className="category">Locations</p>
                    </h6>
                </div>
                <Row>
                    <Col lg={4} sm={6}>
                        <StatsCard
                            bigIcon={
                                <i className="pe-7s-map-marker text-warning" />
                            }
                            statsText="Locations Sent"
                            statsValue={latestLocationFile.locations_count}
                            statsIcon={<i className="fa fa-refresh" />}
                            statsIconText={`Uploaded at : ${latestLocationFile.uploaded_at}`}
                        />
                    </Col>
                    <Col lg={4} sm={6}>
                        <StatsCard
                            bigIcon={<i className="pe-7s-check text-success" />}
                            statsText="Published"
                            statsValue={latestLocationFile.pubCount}
                        />
                    </Col>
                    <Col lg={4} sm={6}>
                        <StatsCard
                            bigIcon={
                                <i className="pe-7s-attention text-danger" />
                            }
                            statsText="Douteux"
                            statsValue={latestLocationFile.doutCount}
                        />
                    </Col>
                </Row>
                <Row>
                    <Col md={8}>
                        <Card
                            statsIcon="fa fa-history"
                            id="chartHours"
                            title="Status of Locations"
                            category="Last month performance"
                            stats=""
                            content={<div className="ct-chart">Chart 1</div>}
                            legend={
                                <div className="legend">
                                    {createLegend(legendSales.locations)}
                                </div>
                            }
                        />
                    </Col>
                    <Col md={4}>
                        <Card
                            statsIcon="fa fa-clock-o"
                            title="Errors Statistics"
                            category="Most Frequent Errors"
                            stats="Campaign sent 2 days ago"
                            content={
                                <div
                                    id="chartPreferences"
                                    className="ct-chart ct-perfect-fourth"
                                >
                                    Chart 2
                                </div>
                            }
                            legend={
                                <div className="legend">
                                    {createLegend(legendPie)}
                                </div>
                            }
                        />
                    </Col>
                </Row>
            </Grid>
            <Grid fluid>
                <div className="typo-line">
                    <h6>
                        <p className="category">Reviews</p>
                    </h6>
                </div>
                <Row>
                    <Col lg={3} sm={6}>
                        <StatsCard
                            bigIcon={
                                <i className="pe-7s-map-marker text-warning" />
                            }
                            statsText="Review Files Sent"
                            statsValue={latestReviewFiles.count}
                            statsIcon={<i className="fa fa-refresh" />}
                            statsIconText={`Uploaded at : ${latestLocationFile.uploaded_at}`}
                        />
                    </Col>
                    <Col lg={3} sm={6}>
                        <StatsCard
                            bigIcon={<i className="pe-7s-check text-success" />}
                            statsText="Files Done"
                            statsValue={latestReviewFiles.doneCount}
                        />
                    </Col>
                    <Col lg={3} sm={6}>
                        <StatsCard
                            bigIcon={
                                <i className="pe-7s-attention text-danger" />
                            }
                            statsText="Files Failed"
                            statsValue={latestReviewFiles.failedCount}
                        />
                    </Col>
                    <Col lg={3} sm={6}>
                        <StatsCard
                            bigIcon={<i className="pe-7s-check text-warning" />}
                            statsText="Reviews Sent"
                            statsValue={latestReviewFiles.reviewsCount}
                        />
                    </Col>
                </Row>
                <Row>
                    <Col md={12}>
                        <Card
                            statsIcon="fa fa-history"
                            id="chartHours"
                            title="Status of Locations"
                            category="Last month performance"
                            stats=""
                            content={<div className="ct-chart">Chart 3</div>}
                            legend={
                                <div className="legend">
                                    {createLegend(legendSales.reviews)}
                                </div>
                            }
                        />
                    </Col>
                </Row>
            </Grid>
        </div>
    ) : (
        <ClipLoader size={350} css={{ display: "block", margin: "auto" }} />
    );
}

const createLegend = json => {
    var legend = [];
    for (var i = 0; i < json["names"].length; i++) {
        var type = "fa fa-circle text-" + json["types"][i];
        legend.push(<i className={type} key={i} />);
        legend.push(" ");
        legend.push(json["names"][i]);
    }
    return legend;
};

export default Dashboard;
