import React, { Component } from "react";
import { Link } from "react-router-dom";
export default class MenuCentral extends Component {
  render() {
    return (
      <div>
        <button
          className="navbar-toggler"
          type="button"
          data-toggle="collapse"
          data-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span className="navbar-toggler-icon"></span>
        </button>

        <div className="collapse navbar-collapse" id="navbarSupportedContent">
          <ul className="navbar-nav mr-auto">
            <li className="nav-item dropdown">
              <a
                className="nav-link d-flex align-items-center py-0 text-white"
                href="#"
                id="navbarDropdown"
                role="button"
                data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false"
              >
                <i className="fas fa-bars mb-2 font-menu-icon mr-3"></i>
                <p className="m-0 font-menu">MENÚ</p>
              </a>
              <div
                className="dropdown-menu bg-color-secondary px-3 dropdown-modified"
                aria-labelledby="navbarDropdown"
              >
                <div className="d-flex align-items-center justify-content-center my-3">
                  <i className="fas fa-user mb-1 mr-1"></i>
                  <p className="m-0 bold">USUARIO</p>
                </div>
                <Link
                  className="dropdown-item border-person border-dark mb-3 py-2 px-2 d-flex align-items-center"
                  to="/inicio"
                >
                  <i className="fas fa-home mb-1 mr-1 size-icon-sm"></i>
                  <p className="m-0 bold">INICIO</p>
                </Link>
                <Link
                  className="dropdown-item border-person mb-3 py-2 px-2 d-flex align-items-center"
                  to="/agenda"
                >
                  <i className="fas fa-calendar mb-1 mx-1 size-icon-sm"></i>
                  <p className="m-0 bold">AGENDA</p>
                </Link>
                <Link
                  className="dropdown-item border-person mb-3 py-2 px-3"
                  to="/inicio"
                >
                  <p className="m-0 bold text-center">INFORMACIÓN GENERAL</p>
                </Link>
                <Link
                  className="dropdown-item border-person mb-3 py-2 px-3"
                  to="/inicio"
                >
                  <p className="m-0 bold text-center">VENTA DE PRODUCTOS</p>
                </Link>
                <div className="d-flex justify-content-between mb-3 mt-4">
                  <Link to="/inicio">
                    <i className="fas fa-cog size-icon icon"></i>
                  </Link>
                  <button>
                    <i className="fas fa-power-off size-icon icon"></i>
                  </button>
                </div>
              </div>
            </li>
          </ul>
        </div>
      </div>
    );
  }
}
