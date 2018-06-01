import React from 'react';

import {capitalize} from '../utils/string-utils.js';

let keyI = 0;

export default class Block extends React.Component {
    render() {
        const title = <h2>{capitalize(this.props.title)}</h2>;

        if (!this.props.shows) {
            return title;
        }

        const rows = this.props.shows.map((show) => {
            return (
                <tr key={'row-' + (keyI++)}>
                    <td width="40%">{show.title}</td>
                    <td width="15%">{show['tickets left']}</td>
                    <td width="15%">{show['tickets available']}</td>
                    <td width="20%">{show.status}</td>
                    <td width="10%">{show.price}</td>
                </tr>
            );
        });

        return (
            <div className="block">
                {title}
                <table>
                    <tbody>
                        <tr>
                            <th>Title</th>
                            <th>Tickets Left</th>
                            <th>Tickets Available</th>
                            <th>Status</th>
                            <th>Price (&euro;)</th>
                        </tr>
                        {rows}
                    </tbody>
                </table>
            </div>
        );
    }
}
