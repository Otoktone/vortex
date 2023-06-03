import React, { useState, useEffect } from "react";

// api url develop TODO : change with env varibale
const apiUrl = "http://localhost:80/api";

const Customize = ({ userId, onUserIdChange }) => {
  // define state variables
  const [showModal, setShowModal] = useState(false);
  const [categories, setCategories] = useState([]);
  const [selectedCategories, setSelectedCategories] = useState([]);
  const [loading, setLoading] = useState(false);
  const [success, setSuccess] = useState(false);
  const [user, setUserId] = useState(null);

  // fetch categories from the API and update state using the useEffect hook
  useEffect(() => {
    const fetchCategories = async () => {
      setLoading(true);
      try {
        const response = await fetch(`${apiUrl}/category/list`);
        const data = await response.json();
        // console.log("API response :", data);
        if (Array.isArray(data.categories)) {
          setCategories(data.categories);
          setUserId(data.user);
          onUserIdChange(data.user);
        }
        setLoading(false);
      } catch (error) {
        console.error(error);
      }
    };
    fetchCategories();
  }, [onUserIdChange]);

  const handleModal = () => {
    setShowModal(!showModal);
  };

  // add or remove a category ID from the selectedCategories array
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

  // submit the selected categories to the API when the form is submitted
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
      const response = await fetch(
        `${apiUrl}/user/category/${urlParams.get("categories")}/${urlParams.get(
          "user"
        )}`,
        {
          method: "GET",
          headers: {
            "Content-Type": "application/json",
          },
        }
      );
      console.log("Submit response :", response, "Data :", data);
      setLoading(false);
      setSuccess(true);
    } catch (error) {
      console.error(error);
      setLoading(false);
    }
  };

  // handle scroll on body when modal is open
  useEffect(() => {
    if (showModal) {
      document.body.classList.add("modal-open");
    } else {
      document.body.classList.remove("modal-open");
    }
  }, [showModal]);

  return (
    <>
      <a className="home_button" href="#" onClick={handleModal}>
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
                  {categories
                    ? categories.map((category) => (
                      <li key={category.id}>
                        <label
                          className="checkbox-label"
                          htmlFor={`category-${category.id}`}
                        >
                          <input
                            className="checkbox-input"
                            type="checkbox"
                            id={`category-${category.id}`}
                            value={category.id}
                            checked={selectedCategories.includes(category.id)}
                            onChange={handleCheckboxChange}
                          />
                          {category.name.charAt(0).toUpperCase() + category.name.slice(1)}
                        </label>
                      </li>
                    ))
                    : null}
                </ul>
              )}
              {success && <p>Categories saved successfully</p>}
              <button type="submit">Save</button>
              <button onClick={handleModal}>Close</button>
            </form>
          </div>
        </div>
      )}
    </>
  );
}

export default Customize;
