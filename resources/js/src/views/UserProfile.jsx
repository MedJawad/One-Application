import React, { useEffect, useState } from "react";
import { Grid, Row, Col } from "react-bootstrap";

import { Card } from "../components/Card/Card.jsx";
import { FormInputs } from "../components/FormInputs/FormInputs.jsx";

import api from "./API";
import { ClipLoader } from "react-spinners";

function UserProfile(props) {
    const [user, setUser] = useState({});
    const [isLoaded, setLoaded] = useState(false);

    const user_id = props.match.params.user_id;

    const fetchFile = user_id => {
        //We do not need a globalized state for the File view so we can just do our api call right here
        // api
        //   .get(`/user/${user_id}`)
        //   .then((res) => (res.status === 200 ? res.data : console.log(res)))
        //   .then((data) => {
        //     setUser(data);
        //     setLoaded(true);
        //   })
        //   .catch((error) => alert("Failed to fetch Data from Server " + error));
    };

    useEffect(() => fetchFile(user_id), [user_id]); //Uncomment this to enable fetching files from API

    return (
        <div className="content">
            <Grid fluid>
                <Row>
                    <Col md={10} mdOffset={1}>
                        <Card
                            title="Edit Profile"
                            content={
                                isLoaded ? (
                                    <form>
                                        <FormInputs
                                            ncols={[
                                                "col-md-2",
                                                "col-md-5",
                                                "col-md-5"
                                            ]}
                                            properties={[
                                                {
                                                    label: "ID",
                                                    type: "text",
                                                    bsClass: "form-control",
                                                    defaultValue: user["id"],
                                                    disabled: true
                                                },
                                                {
                                                    label: "Username",
                                                    type: "text",
                                                    bsClass: "form-control",
                                                    defaultValue:
                                                        user["username"],
                                                    disabled: true
                                                },
                                                {
                                                    label: "Email address",
                                                    type: "email",
                                                    bsClass: "form-control",
                                                    defaultValue: user["email"],
                                                    disabled: true
                                                }
                                            ]}
                                        />
                                        <FormInputs
                                            ncols={["col-md-6", "col-md-6"]}
                                            properties={[
                                                {
                                                    label: "First name",
                                                    type: "text",
                                                    bsClass: "form-control",
                                                    defaultValue:
                                                        user["first_name"],
                                                    disabled: true
                                                },
                                                {
                                                    label: "Last name",
                                                    type: "text",
                                                    bsClass: "form-control",
                                                    defaultValue:
                                                        user["last_name"],
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
                                                    defaultValue:
                                                        user["created_at"],
                                                    disabled: true
                                                },
                                                {
                                                    label: "Updated At",
                                                    type: "text",
                                                    bsClass: "form-control",
                                                    defaultValue:
                                                        user["updated_at"],
                                                    disabled: true
                                                },
                                                {
                                                    label: "Deleted At",
                                                    type: "number",
                                                    bsClass: "form-control",
                                                    defaultValue:
                                                        user["deleted_at"],
                                                    disabled: true
                                                }
                                            ]}
                                        />
                                        {/* <Button bsStyle="info" pullRight fill type="submit">
                    Update Profile
                  </Button> */}
                                        <div className="clearfix" />
                                    </form>
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

export default UserProfile;
