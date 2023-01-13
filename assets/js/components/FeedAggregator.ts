// contient la logique à exécuter lorsqu'une commande est reçue
interface UserReceiver {
    createUser(): void;
    modifyUser(): void;
    deleteUser(): void;
}

// contient les logiques de création, modification et suppression d'un utilisateur
class UserCommand implements UserReceiver {
    constructor(private user: object) {
        this.user = user;
    }
    createUser() {
        console.log("Utilisateur " + this.user.name + " créé !");
    }
    modifyUser() {
        console.log("Utilisateur " + this.user.name + " modifié !");
    }
    deleteUser() {
        console.log("Utilisateur " + this.user.name + " supprimé !");
    }
}

// méthode pour exécuter la commande
interface Command {
	execute(): void;
}

// ajout utilisateur via méthode implémentée par interface command
class AddUserCommand implements Command {
    constructor(private UserReceiver) {
        this.UserReceiver = UserReceiver;
    }
    execute() {
        this.UserReceiver.createUser();
    }
}

// modifie utilisateur via méthode implémentée par interface command
class ModifyUserCommand implements Command {
    constructor(private UserReceiver) {
        this.UserReceiver = UserReceiver;
    }
    execute() {
        this.UserReceiver.modifyUser();
    }
}

// supprime utilisateur via méthode implémentée par interface command
class DeleteUserCommand implements Command {
    constructor(private UserReceiver) {
        this.UserReceiver = UserReceiver;
    }
    execute() {
        this.UserReceiver.deleteUser();
    }
}

// stock et execute les commandes
class UserInvoker {
    constructor(public commands) {
        this.commands = [];
    }
    setCommand(command) {
        this.commands.push(command);
    }
    executeCommands() {
        this.commands.forEach(command => command.execute());
    }
}




// interface Command {
//     execute(): void;
// }

// class AddUserCommand implements Command {
//     constructor(private user: object) {
//         this.user = user;
//     }

//     execute() {
//         // add user into db
//     }
// }

// class ModifyUserCommand implements Command {
//     constructor(private user: object) {
//         this.user = user;
//     }

//     execute() {
//         // update user into db
//     }
// }

// class DeleteUserCommand implements Command {
//     constructor(private user: object) {
//         this.user = user;
//     }

//     execute() {
//         // delete user from db
//     }
// }

// const user = { name: "Bob Morane", email: "bob.morane@truc.com" };
// const addUserCommand = new AddUserCommand(user);
// const modifyUserCommand = new ModifyUserCommand(user);
// const deleteUserCommand = new DeleteUserCommand(user);
// addUserCommand.execute();
// modifyUserCommand.execute();
// deleteUserCommand.execute();


/**
 * JAVASCRIPT
 */

// // The Command interface
// class Command {
//   execute() {}
// }

// // The ConcreteCommand classes
// class FetchRssFeedCommand extends Command {
//   constructor(feed) {
//     super();
//     this.feed = feed;
//   }

//   execute() {
//     this.feed.fetch();
//   }
// }

// class FetchApiFeedCommand extends Command {
//   constructor(feed) {
//     super();
//     this.feed = feed;
//   }

//   execute() {
//     this.feed.fetch();
//   }
// }

// // The Receiver classes
// class RssFeed {
//   constructor(url) {
//     this.url = url;
//   }

//   fetch() {
//     console.log(`Fetching RSS feed from ${this.url}`);
//   }
// }

// class ApiFeed {
//   constructor(url) {
//     this.url = url;
//   }

//   fetch() {
//     console.log(`Fetching API feed from ${this.url}`);
//   }
// }

// // The Client
// class FeedAggregator {
//   constructor() {
//     this.commands = [];
//   }

//   addRssFeed(url) {
//     const feed = new RssFeed(url);
//     const command = new FetchRssFeedCommand(feed);
//     this.commands.push(command);
//   }

//   addApiFeed(url) {
//     const feed = new ApiFeed(url);
//     const command = new FetchApiFeedCommand(feed);
//     this.commands.push(command);
//   }

//   fetchAll() {
//     this.commands.forEach(command => command.execute());
//   }
// }

// // Example usage
// const aggregator = new FeedAggregator();
// aggregator.addRssFeed('http://rss-feed1.com');
// aggregator.addApiFeed('http://api-feed1.com');
// aggregator.fetchAll();
// // Output:
// // Fetching RSS feed from http://rss-feed1.com
// // Fetching API feed from http://api-feed1.com



/**
 * TYPESCRIPT
 */

// // The Command interface
// interface Command {
//   execute(): void;
// }

// // The ConcreteCommand classes
// class FetchRssFeedCommand implements Command {
//   constructor(private feed: RssFeed) {}

//   execute(): void {
//     this.feed.fetch();
//   }
// }

// class FetchApiFeedCommand implements Command {
//   constructor(private feed: ApiFeed) {}

//   execute(): void {
//     this.feed.fetch();
//   }
// }

// // The Receiver classes
// class RssFeed {
//   constructor(private url: string) {}

//   fetch(): void {
//     console.log(`Fetching RSS feed from ${this.url}`);
//   }
// }

// class ApiFeed {
//   constructor(private url: string) {}

//   fetch(): void {
//     console.log(`Fetching API feed from ${this.url}`);
//   }
// }

// // The Client
// class FeedAggregator {
//   private commands: Command[] = [];

//   addRssFeed(url: string): void {
//     const feed = new RssFeed(url);
//     const command = new FetchRssFeedCommand(feed);
//     this.commands.push(command);
//   }

//   addApiFeed(url: string): void {
//     const feed = new ApiFeed(url);
//     const command = new FetchApiFeedCommand(feed);
//     this.commands.push(command);
//   }

//   fetchAll(): void {
//     this.commands.forEach(command => command.execute());
//   }
// }

// // Example usage
// const aggregator = new FeedAggregator();
// aggregator.addRssFeed('http://rss-feed1.com');
// aggregator.addApiFeed('http://api-feed1.com');
// aggregator.fetchAll();
// // Output:
// // Fetching RSS feed from http://rss-feed1.com
// // Fetching API feed from http://api-feed1.com
