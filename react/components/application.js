import React from 'react';
import ReactDOM from 'react-dom';

import DateFilter from './date-filter.js';
import Block from './block.js';

import {httpPost} from './../utils/ajax.js';
import {padStart} from '../utils/string-utils.js';

export default class Application extends React.Component {
    constructor() {
        super();

        const Dt = new Date();
        this.state = {
            date: `${Dt.getFullYear()}-${padStart(Dt.getMonth() + 1, 2)}-${padStart(Dt.getDate(), 2)}`,
            inventory: null,
            error: null
        };
        this.submit(this.state.date);
    }

    submit(date) {
        httpPost('api.php', {date})
            .then((obj) => {this.updateInventory(obj)})
            .catch((err) => {this.updateInventory(null, err)});
    }

    updateInventory(obj, err = null) {
        this.setState({
            inventory: obj && obj.inventory || null,
            error: err
        });
    }

    getInventoryBlocks() {
        if (this.state.error) {
            return <Block key="error" title={this.state.error} shows={null}/>;
        }
        if (!this.state.inventory) {
            return '';
        }

        const inventory = this.state.inventory;
        const blocks = inventory.map((el) => {
            return <Block key={el.genre} title={el.genre} shows={el.shows}/>;
        });

        if (!blocks.length) {
            return <Block key="results" title="Nothing found" shows={null}/>;
        }

        return blocks;
    }

    render() {
        return (
            <div className="application">
                <DateFilter date={this.state.date} callbackSubmit={(date)=>{this.submit(date)}} />
                {this.getInventoryBlocks()}
            </div>
        );
    }
}
