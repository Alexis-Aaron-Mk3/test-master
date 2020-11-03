import React, { Component } from "react";
import { Link } from "react-router-dom";
import Logo from "../../images/logo.png";

export default class NavbarBrand extends Component {
  render() {
    return (
      <div>
        <Link className="navbar-brand" to="/">
          <img src={Logo} alt={"logo"} className="logo" />
        </Link>
      </div>
    );
  }
}
