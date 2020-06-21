import React, { Component } from "react";

class Footer extends Component {
    render() {
        return (
            <footer
                className="footer"
                style={{ position: "fixed", bottom: "0", width: "100%" }}
            >
                <p className="copyright pull-left">
                    TOGETHER WE LEAD THE WAY AT ONEEP &copy;{" "}
                    {new Date().getFullYear()}
                </p>
            </footer>
        );
    }
}

export default Footer;
