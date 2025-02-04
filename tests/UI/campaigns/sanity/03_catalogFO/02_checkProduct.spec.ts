/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License version 3.0
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License version 3.0
 */
import {
  // Import FO pages
  foClassicHomePage,
  foClassicProductPage,
  // Import data
  dataProducts,
} from '@prestashop-core/ui-testing';

import {
  test, expect, Page, BrowserContext,
} from '@playwright/test';

/*
  Open the FO home page
  Check the first product page
 */
test.describe('FO - Catalog : Check the Product page', async () => {
  let browserContext: BrowserContext;
  let page: Page;

  test.beforeAll(async ({browser}) => {
    browserContext = await browser.newContext();
    page = await browserContext.newPage();
  });
  test.afterAll(async () => {
    await page.close();
  });

  // Steps
  test('should open the shop page', async () => {
    await foClassicHomePage.goTo(page, global.FO.URL);

    const result = await foClassicHomePage.isHomePage(page);
    expect(result).toEqual(true);
  });

  test('should go to the first product page', async () => {
    await foClassicHomePage.goToProductPage(page, 1);

    const pageTitle = await foClassicProductPage.getPageTitle(page);
    expect(pageTitle).toBeDefined();
  });

  test('should check the product page', async () => {
    const result = await foClassicProductPage.getProductInformation(page);

    if (result.name === dataProducts.demo_1.name) {
      await Promise.all([
        expect(result.name).toEqual(dataProducts.demo_1.name),
        expect(result.price).toEqual(dataProducts.demo_1.finalPrice),
        expect(result.description).toContain(dataProducts.demo_1.description),
      ]);
    } else {
      await Promise.all([
        expect(result.name).toEqual(dataProducts.old_demo_1.name),
        expect(result.price).toEqual(dataProducts.old_demo_1.finalPrice),
        expect(result.description).toContain(dataProducts.old_demo_1.description),
      ]);
    }
  });
});
