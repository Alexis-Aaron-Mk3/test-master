import React, { Component } from "react";
import { Link } from "react-router-dom";
import "./RegisterPage.css";

export default class RegisterPage extends Component {
  render() {
    return (
      <div className="background">
        <div className="container">
          <h2 className="text-light py-5 text-center fs-registro">
            Regístrate Aquí
          </h2>
          <form>
            <div className="row d-flex flex-column align-items-center">
              <div className="col-12 mb-3">
                <div className="row d-flex justify-content-center">
                  <div className="col-4">
                    <input type="text" className="" placeholder="Nombre:" />
                  </div>
                  <div className="col-4">
                    <input type="text" className="" placeholder="Apellido:" />
                  </div>
                </div>
              </div>

              <div className="col-8 mb-3">
                <input type="email" placeholder="Correo electrónico:" />
              </div>
              <div className="col-8 mb-3">
                <input type="password" placeholder="contraseña:" />
              </div>
              <div className="col-8 mb-3">
                <input type="password" placeholder="Confirme la contraseña:" />
              </div>
              <div className="row  mb-4">
                <div className="col-12 text-center d-flex flex-column align-items-center">
                  <label className="text-light">Fecha de Nacimiento:</label>
                  <input type="date" />
                </div>
                <div className="col-12 d-flex justify-content-center text-light">
                  <div className="row">
                    <div className="col-12 text-center">
                      <label>sexo:</label>
                    </div>
                    <div className="col d-flex align-items-center ">
                      <input
                        type="radio"
                        id="male"
                        name="gender"
                        value="male"
                        className="mb-3"
                      />
                      <label for="male">Male</label>
                    </div>
                    <div className="col d-flex align-items-center">
                      <input
                        type="radio"
                        id="female"
                        name="gender"
                        value="female"
                        className="mb-3"
                      />
                      <label for="female">Female</label>
                    </div>
                  </div>
                </div>
              </div>
              <div>
                {/* funcion provisional */}
                <Link to="/">
                  <button type="submit" className="button mx">
                    Finalizar
                  </button>
                </Link>
              </div>
            </div>
          </form>
        </div>
      </div>
    );
  }
}
