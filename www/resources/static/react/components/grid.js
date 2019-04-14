import React, { Component } from "react";
import StackGrid from "react-stack-grid";

/* eslint-disable react/prop-types */
// import React from 'react';
// import StackGrid, { transitions, easings } from '../../../src/';


// const transition = transitions.scaleDown;

const images = [
    { src: 'https://tsuyoshiwada.github.io/react-stack-grid/images/photos/photo01.jpg', label: 'Sample image 1' },
    { src: 'https://tsuyoshiwada.github.io/react-stack-grid/images/photos/photo02.jpg', label: 'Sample image 2' },
    { src: 'https://tsuyoshiwada.github.io/react-stack-grid/images/photos/photo03.jpg', label: 'Sample image 3' },
    { src: 'https://tsuyoshiwada.github.io/react-stack-grid/images/photos/photo04.jpg', label: 'Sample image 4' },
    { src: 'https://tsuyoshiwada.github.io/react-stack-grid/images/photos/photo05.jpg', label: 'Sample image 5' },
    { src: 'https://tsuyoshiwada.github.io/react-stack-grid/images/photos/photo06.jpg', label: 'Sample image 6' },
    { src: 'https://tsuyoshiwada.github.io/react-stack-grid/images/photos/photo07.jpg', label: 'Sample image 7' },
    { src: 'https://tsuyoshiwada.github.io/react-stack-grid/images/photos/photo08.jpg', label: 'Sample image 8' },
    { src: 'https://tsuyoshiwada.github.io/react-stack-grid/images/photos/photo09.jpg', label: 'Sample image 9' },
    { src: 'https://tsuyoshiwada.github.io/react-stack-grid/images/photos/photo10.jpg', label: 'Sample image 10' },
    { src: 'https://tsuyoshiwada.github.io/react-stack-grid/images/photos/photo11.jpg', label: 'Sample image 11' },
    { src: 'https://tsuyoshiwada.github.io/react-stack-grid/images/photos/photo12.jpg', label: 'Sample image 12' },
    { src: 'https://tsuyoshiwada.github.io/react-stack-grid/images/photos/photo13.jpg', label: 'Sample image 13' },
    { src: 'https://tsuyoshiwada.github.io/react-stack-grid/images/photos/photo14.jpg', label: 'Sample image 14' },
    { src: 'https://tsuyoshiwada.github.io/react-stack-grid/images/photos/photo15.jpg', label: 'Sample image 15' },
    { src: 'https://tsuyoshiwada.github.io/react-stack-grid/images/photos/photo16.jpg', label: 'Sample image 16' },
    { src: 'https://tsuyoshiwada.github.io/react-stack-grid/images/photos/photo17.jpg', label: 'Sample image 17' },
    { src: 'https://tsuyoshiwada.github.io/react-stack-grid/images/photos/photo18.jpg', label: 'Sample image 18' },
    { src: 'https://tsuyoshiwada.github.io/react-stack-grid/images/photos/photo19.jpg', label: 'Sample image 19' },
    { src: 'https://tsuyoshiwada.github.io/react-stack-grid/images/photos/photo20.jpg', label: 'Sample image 20' },
    { src: 'https://tsuyoshiwada.github.io/react-stack-grid/images/photos/photo21.jpg', label: 'Sample image 21' },
    { src: 'https://tsuyoshiwada.github.io/react-stack-grid/images/photos/photo22.jpg', label: 'Sample image 22' },
];

import sizeMe from 'react-sizeme';

class MyComponent extends Component {
    render() {
        const {
            size: {
                width
            }
        } = this.props;

        console.log(width);
        return (
            <StackGrid
                monitorImagesLoaded
                columnWidth={width <= 768 ? '100%' : '33.33%'}
                // duration={600}
                gutterWidth={15}
                gutterHeight={15}
                appearDelay={60}
            >
                {images.map(obj => (
                    <figure
                        key={obj.src}
                        className="image"
                    >
                        <img src={obj.src} alt={obj.label} />
                        <figcaption>{obj.label}</figcaption>
                    </figure>
                ))}
            </StackGrid>
        );
    }
}

export default sizeMe()(MyComponent);