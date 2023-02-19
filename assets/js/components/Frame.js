import React, { useState } from 'react';
import { motion } from 'framer-motion';
import frame1 from '../../images/frames/frame1.jpg';
import frame2 from '../../images/frames/frame2.jpg';
import frame3 from '../../images/frames/frame3.jpg';
import frame4 from '../../images/frames/frame4.jpg';

const frames = [
    { id: 1, src: frame1, class:'fa-brands fa-hotjar', title: 'Stay updated', text: 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Lorem ipsum dolor sit amet, consectetur adipisicing elit.' },
    { id: 2, src: frame2, class:'fa-solid fa-bookmark', title: 'Bookmark articles', text: 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.' },
    { id: 3, src: frame3, class:'fa-solid fa-gear', title: 'Customize feed', text: 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.' },
    { id: 4, src: frame4, class:'fa-solid fa-rss', title: 'Follow news', text: 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.' },
];

// init composant state with frame1
const FrameComponent = () => {
    const [selectedPart, setSelectedPart] = useState(frames[0]);

    // onclick update state according to id
    const handleClick = (part) => {
        if (selectedPart.id === part.id) {
            // reinitialize state to frame1
            setSelectedPart(frames[0]);
        } else {
        setSelectedPart(part);
        }
    };

    return (
        <div className='frame_container'>
            <div className='frame_box'>
                {frames.map((frame) => (
                    <motion.img
                        key={frame.id}
                        src={frame.src}
                        onClick={() => handleClick(frame)}
                        animate={{
                        scale: selectedPart.id === frame.id ? 1.2 : 1,
                        }}
                        transition={{ duration: 0.5 }}
                    />
                ))}
            </div>
            <div className='frame_info'>
                {frames.map((frame) => (
                    <div
                        className={`info${frame.id} ${selectedPart.id === frame.id ? 'active' : ''}`}
                        key={frame.id}
                    >
                        <h3><i className={`${frame.class}`}></i>{frame.title}</h3>
                        <p>{frame.text}</p>
                    </div>
                ))}
            </div>
        </div>
    );
};

export default FrameComponent;