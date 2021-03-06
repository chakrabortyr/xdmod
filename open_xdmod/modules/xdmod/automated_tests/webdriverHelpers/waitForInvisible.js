/*
 *  Wait for selector to be invisible
 *
 *  @param {string} selector - element to check
 *  @param {Number} [ms=1000] - Milliseconds to wait for element to be invisible
 *
 *  @uses commands/waitForVisible
 */

module.exports = function waitForInvisible(selector, ms) {
    var timeOut = ms || 1000;
    return this.waitForVisible(selector, timeOut, true);
};
