import React, { Component } from "react";
import { Link } from "react-router-dom";
import Logo from "../../assets/img/logo/logo.png";
import "./LoginPage.css";

class LoginPage extends Component {
  render() {
    return (
      <div className="background">
        <div className="container">
          <div className="row pt-5 mb-4">
            <img src={Logo} className="logoLogin" />
          </div>
          <div className="row">
            <form className="mx-auto">
              <div class="form-group ">
                <input type="text" className="mx-auto" placeholder="Usuario" />
              </div>

              <div class="form-group">
                <input type="password" placeholder="Contraseña" />
              </div>
              <div className="d-flex flex-column align-items-center">
                {/* codigo de prueba */}
                <Link to="/inicio" style={{ border: "none" }}>
                  <button type="submit" class="button fb">
                    Iniciar Sesión
                  </button>
                </Link>

                <Link
                  to="/recuperar-contrasena"
                  style={{ color: "white" }}
                  className="mt-3"
                >
                  Recuperar Contraseña
                </Link>
              </div>

              <div className="d-flex flex-column align-items-center mt-4">
                <p className="text-light fs">¿Aún no tienes una cuenta?</p>
                <Link to="/registrar" style={{ border: "none" }}>
                  <button className="button fb">Registrate Aquí</button>
                </Link>
              </div>
            </form>
          </div>
        </div>
      </div>
    );
  }
}

export default LoginPage;
