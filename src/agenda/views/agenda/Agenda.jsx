import React, { Component } from "react";
import { Calendar, momentLocalizer } from "react-big-calendar";
import moment from "moment";
import withDragAndDrop from "react-big-calendar/lib/addons/dragAndDrop";
import "./Agenda.css";
import "react-big-calendar/lib/addons/dragAndDrop/styles.css";
import Navbar from '../../Components/Navbar/Navbar';
require("moment/locale/es.js");

const localizer = momentLocalizer(moment);
const DnDCalendar = withDragAndDrop(Calendar);

export default class EventsCalendar extends Component {
  constructor(props) {
    super(props);
    this.state = {
      events: [
        {
          start: moment().toDate(),
          end: moment().add(1, "days").toDate(),
          title: "Some title",
        },
      ],
    };
    this.moveEvent = this.moveEvent.bind(this);
  }

  moveEvent({ event, start, end }) {
    const { events } = this.state;

    const idx = events.indexOf(event);
    const updatedEvent = { ...event, start, end };

    const nextEvents = [...events];
    nextEvents.splice(idx, 1, updatedEvent);

    this.setState({
      events: nextEvents,
    });
  }

  onEventResize = (data) => {
    const { start, end } = data;

    this.setState((state) => {
      state.events[0].start = start;
      state.events[0].end = end;
      return { events: state.events };
    });
  };

  render() {
    return (
      <>
      <Navbar />
      <div className="App px-4 py-3 bg-color-secondary">
        <DnDCalendar
          selectable
          resizable
          defaultDate={moment().toDate()}
          defaultView="month"
          events={this.state.events}
          localizer={localizer}
          onEventDrop={this.moveEvent}
          onEventResize={this.onEventResize}      
          style={{ height: "83vh" }}
        />
      </div>
      </>
    );
  }
}
