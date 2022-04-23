import styled from "styled-components";

export const Container = styled.div`
  width: 100%;
  height: 100vh;
  background-color: ${(props) => (props.color ? props.color : "tomato")};
`;

export const Card = styled.div`
  width: 33.3%;
  height: 100px;
  background-color: white;
`;
