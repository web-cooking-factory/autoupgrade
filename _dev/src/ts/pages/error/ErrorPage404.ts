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
import api from '../../api/RequestHandler';
import DomLifecycle from '../../types/DomLifecycle';

export default class ErrorPage404 implements DomLifecycle {
  isOnHomePage: boolean = false;

  public constructor() {
    this.isOnHomePage = new URLSearchParams(window.location.search).get('route') === 'home-page';
  }

  public mount = (): void => {
    this.#activeActionButton.classList.remove('hidden');
    this.#form.addEventListener('submit', this.#onSubmit);
  };

  public beforeDestroy = (): void => {
    this.#form.removeEventListener('submit', this.#onSubmit);
  };

  get #activeActionButton(): HTMLFormElement | HTMLAnchorElement {
    return this.isOnHomePage ? this.#exitButton : this.#form;
  }

  get #form(): HTMLFormElement {
    const form = document.forms.namedItem('home-page-form');
    if (!form) {
      throw new Error('Form not found');
    }

    ['routeToSubmit'].forEach((data) => {
      if (!form.dataset[data]) {
        throw new Error(`Missing data ${data} from form dataset.`);
      }
    });

    return form;
  }

  get #exitButton(): HTMLAnchorElement {
    const link = document.getElementById('exit-button');

    if (!link || !(link instanceof HTMLAnchorElement)) {
      throw new Error('Link is not found or invalid');
    }
    return link;
  }

  readonly #onSubmit = async (event: Event): Promise<void> => {
    event.preventDefault();

    await api.post(this.#form.dataset.routeToSubmit!, new FormData(this.#form));
  };
}
