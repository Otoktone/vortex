import React from 'react';
import imgPath from '../../images/dashboard.jpg';

export default function Carousel() {
    return (
        <div className='carousel_container'>
            <div>
                <img src={imgPath} alt="dasbhoard slider image"></img>
            </div>
            <div className='carousel_info'>
                <h3>titre</h3>
                <p>lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum </p>
            </div>
        </div>
    );
}



