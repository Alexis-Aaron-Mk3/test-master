import React, { Component } from "react";
import { Link } from "react-router-dom";
import MSJ from "../../images/msj.svg";
import USER from "../../images/usuario.svg";
import SUC from "../../images/sucursales.svg";
export default class MenuDerecho extends Component {
  render() {
    return (
      <div>
        <ul className="navbar-nav mr-auto">
          <li className="nav-item ">
            <Link
              className="nav-link d-flex flex-column justify-content-center"
              to="/"
            >
              <img src={SUC} className="icon-menu" />
              <p className="m-0">Sucursales</p>
            </Link>
          </li>
          <li className="nav-item">
            <Link
              className="nav-link d-flex flex-column justify-content-center"
              to="/"
            >
              <img src={MSJ} className="icon-menu" />
              <p className="m-0">Mensajes</p>
            </Link>
          </li>
          <li className="nav-item">
            <Link
              className="nav-link d-flex flex-column justify-content-center "
              to="/"
            >
              <img src={USER} className="icon-menu" />
              <p className="m-0">Usuario</p>
            </Link>
          </li>
        </ul>
      </div>
    );
  }
}
