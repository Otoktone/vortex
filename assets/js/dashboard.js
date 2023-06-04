// import React, { useState, useEffect } from 'react';
// import { createRoot } from 'react-dom/client';

// import FeedArticles from './components/FeedArticle';
// import Customize from './components/Customize';

// const Dashboard = () => {
//     const [userId, setUserId] = useState(null);
//     const [categories, setCategories] = useState([]);

//     const handleCategoryChange = (selectedCategories) => {
//         setCategories(selectedCategories);
//     };

//     useEffect(() => {
//         const fetchUserCategories = async () => {
//             try {
//                 const response = await fetch('http://localhost:80/api/user/categories');
//                 if (response.ok) {
//                     const data = await response.json();
//                     setCategories(data.categories);
//                     console.log("Fetched categories: ", data);
//                 } else {
//                     console.error('Failed to fetch user categories');
//                 }
//             } catch (error) {
//                 console.error(error);
//             }
//         };

//         fetchUserCategories();
//     }, []);

//     const handleUserIdChange = (newUserId) => {
//         setUserId(newUserId);
//     };

//     return (
//         <div>
//             <Customize
//                 userId={userId}
//                 onUserIdChange={handleUserIdChange}
//                 categories={categories}
//                 onCategoryChange={handleCategoryChange}
//             />
//             <FeedArticles userId={userId} categories={categories} />
//         </div>
//     );
// };

// const rootElement = document.getElementById('feed');
// createRoot(rootElement).render(<Dashboard />);
