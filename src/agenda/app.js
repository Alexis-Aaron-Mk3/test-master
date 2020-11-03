import React from "react";
import { BrowserRouter as Router, Route, Switch } from "react-router-dom";
import EventsCalendar from "./views/agenda/Agenda";
import Home from "./views/HomePage/Home";
import RegisterPage from "./views/RegisterPage/RegisterPage";
import LoginPage from "./views/LoginPage/LoginPage";

export default class App extends React.Component {
  render() {
    return (
      <>
        <Router>
          <Switch>
            <Route path="/agenda">
              <EventsCalendar />
            </Route>
            <Route path="/registrar">
              <RegisterPage />
            </Route>
            <Route path="/inicio">
              <Home />
            </Route>
            <Route path="/">
              <LoginPage />
            </Route>
          </Switch>
        </Router>
      </>
    );
  }
}
