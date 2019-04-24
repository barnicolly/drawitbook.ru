import React, {Component} from "react";
import Grid from './Grid';

import '../styles/App.css';

var test;
class App extends Component {
    render() {
        return (
            <div className={"clearfix"}>
                <Grid/>
            </div>
        );
    }
}

export default App;