import React from 'react';
import ReactDOM from 'react-dom';

export default class DateFilter extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
            wrongDate: false,
            date: props.date
        }
    }

    change(event) {
        let date = event.target.value;
        let wrongDate = false;
        if (!/^\d{4}-\d{2}-\d{2}$/.test(date)) {
            wrongDate = true;
        }
        this.setState({date, wrongDate});
    }

    submit() {
        if (this.state.wrongDate) {
            return;
        }
        if (this.props.callbackSubmit) {
            this.props.callbackSubmit(this.state.date);
        }
    }

    render() {
        return (
            <div className="date-filter">
                <span>Show date</span>
                <input
                    type="date"
                    defaultValue={this.state.date}
                    onChange={(e) => {this.change(e);}}
                />
                <input
                    type="button"
                    value="submit"
                    onClick={() => {this.submit();}}
                />
                {this.state.wrongDate ? <div>Please use correct date.</div>: ''}
            </div>
        );
    }
}
