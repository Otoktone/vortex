import React, { useState, useEffect } from "react";

const apiUrl = "http://localhost:80/api";

function MyModal() {
  const [showModal, setShowModal] = useState(false);
  const [categories, setCategories] = useState([]);
  const [selectedCategories, setSelectedCategories] = useState([]);
  const [loading, setLoading] = useState(false);
  const [success, setSuccess] = useState(false);
  const [user, setUserId] = useState(null);

  useEffect(() => {
    const fetchCategories = async () => {
      setLoading(true);
      try {
        const response = await fetch(`${apiUrl}/category/list`);
        const data = await response.json();
        console.log('API response:', data);
        if (Array.isArray(data.categories)) {
          setCategories(data.categories);
          setUserId(data.user);
        }
        setLoading(false);
      } catch (error) {
        console.error(error);
      }
    };
    fetchCategories();
  }, []);

  useEffect(() => {
    if (showModal) {
      document.body.classList.add("modal-open");
    } else {
      document.body.classList.remove("modal-open");
    }
  }, [showModal]);

  const handleModal = () => {
    setShowModal(!showModal);
  };

  const handleCheckboxChange = (event) => {
    const categoryId = parseInt(event.target.value);
    const isChecked = event.target.checked;

    if (isChecked) {
      setSelectedCategories([...selectedCategories, categoryId]);
    } else {
      setSelectedCategories(
        selectedCategories.filter((id) => id !== categoryId)
      );
    }
  };

  const handleSubmit = async (event) => {
    event.preventDefault();
    setLoading(true);
    try {
      const data = {
        categories: selectedCategories.join(","),
        user: user,
      };
      const urlParams = new URLSearchParams({
          categories: selectedCategories.join(","),
          user: user,
      });
      const response = await fetch(`${apiUrl}/user/category/${urlParams.get('categories')}/${urlParams.get('user')}`, {
          method: "GET",
          headers: {
              "Content-Type": "application/json",
          },
      });
      setLoading(false);
      setSuccess(true);
    } catch (error) {
      console.error(error);
      setLoading(false);
    }
  };

  return (
    <>
      <a href="#" onClick={handleModal}>
        <i className="fa-solid fa-gear"></i>
        <span>Customize</span>
      </a>
      {showModal && (
        <div className="modal-overlay">
          <div className="modal-content">
            <form onSubmit={handleSubmit}>
              <p>Custom your feed : </p>
              {loading ? (
                <p>Loading categories...</p>
              ) : (
                <ul>
                  {categories ? (
                    categories.map((category) => (
                      <li key={category.id}>
                        <label className="checkbox-label" htmlFor={`category-${category.id}`}>
                        <input
                          className="checkbox-input"
                          type="checkbox"
                          id={`category-${category.id}`}
                          value={category.id}
                          checked={selectedCategories.includes(category.id)}
                          onChange={handleCheckboxChange}
                        />
                        {category.name}
                      </label>
                      </li>
                    ))
                  ) : null}
                </ul>
              )}
              {success && (
                <p>Categories saved successfully</p>
              )}
              <button type="submit">Save</button>
              <button onClick={handleModal}>Close</button>
            </form>
          </div>
        </div>
      )}
    </>
  );
}

export default MyModal;
