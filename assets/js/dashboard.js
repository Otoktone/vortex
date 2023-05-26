// REACT
import React, { useState } from 'react';
import { createRoot } from 'react-dom/client';

import FeedArticles from './components/FeedArticle';
import Customize from './components/Customize';

const Dashboard = () => {
    const [userId, setUserId] = useState(null);

    const handleUserIdChange = (newUserId) => {
        setUserId(newUserId);
    };
    // console.log(userId);
    return (
        <div>
            <Customize userId={userId} onUserIdChange={handleUserIdChange} />
            <FeedArticles userId={userId} />
        </div>
    );
};

const rootElement = document.getElementById('feed');
createRoot(rootElement).render(<Dashboard />);
