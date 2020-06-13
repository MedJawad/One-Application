import React from "react";
import { Nav, NavItem } from "react-bootstrap";

const Pagination = ({
  itemsPerPage,
  totalItems,
  currentPage,
  setCurrentPage
}) => {
  const pageNumbers = [];

  for (let i = 1; i <= Math.ceil(totalItems / itemsPerPage); i++) {
    pageNumbers.push(i);
  }
  const visiblePageNumbers = pageNumbers.filter(
    number =>
      Math.abs(currentPage - number) < 5 ||
      (currentPage < 5 && number < 10) ||
      (pageNumbers.length - currentPage < 5 && number > pageNumbers.length - 10)
  );

  const paginate = pageNumber => {
    if (pageNumber >= 1 && pageNumber <= pageNumbers.length) {
      setCurrentPage(pageNumber);
    }
  };

  return (
    <Nav className="col-md-offset-4" bsStyle="pills" activeKey={currentPage}>
      <NavItem onClick={() => paginate(currentPage - 1)}>
        <i className="pe-7s-angle-left"></i> Previous
      </NavItem>
      {visiblePageNumbers.map(number => (
        <NavItem
          key={number}
          eventKey={number}
          onClick={() => paginate(number)}
        >
          {number}
        </NavItem>
      ))}
      <NavItem onClick={() => paginate(currentPage + 1)}>
        Next <i className="pe-7s-angle-right"></i>
      </NavItem>
    </Nav>
  );
};

export default Pagination;
