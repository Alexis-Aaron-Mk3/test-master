import React, { Component } from "react";
import NavbarBrand from "./NavbarBrand";
import MenuCentral from "./MenuCentral";
import MenuDerecho from "./MenuDerecho";

import "./Navbar.css";

export default class Navbar extends Component {
  render() {
    return (
      <nav className="navbar navbar-expand-lg navbar-dark d-flex justify-content-between">
        <NavbarBrand />
        <MenuCentral />
        <MenuDerecho />
      </nav>
    );
  }
}
