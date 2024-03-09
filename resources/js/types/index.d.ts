export interface User {
    id: number;
    name: string;
    email: string;
    email_verified_at: string;
}
export interface Article {
    title: string
    content: string
    id: number
    created_at: string
    updated_at: string
    user: User
    updater: User
    draft: boolean
    multi: boolean
    tags: Array<Tag>
}

export interface Image {
    desc: string
    filename: string
    id: number
    created_at: string
    updated_at: string
    user: User
    width: number
    height: number
}
export interface Tag {
    name: string
    color: string
}
export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    auth: {
        user: User;
    };
};
