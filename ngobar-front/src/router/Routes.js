import React from "react";
import { Routes as Switch, Route } from "react-router-dom";
import { Home, Testing } from "../pages";

const Routes = () => {
  return (
    <Switch>
      <Route index element={<Home />} />
      <Route path="/404" element={<Testing />} />
      <Route path="*" element={<Testing />} />
    </Switch>
  );
};

export default Routes;
